# 08 — Booking Workflow & Lifecycle

## 1. Document Purpose
This document defines the complete end-to-end booking lifecycle for Oliver Transport, including the instant booking paradigm, the **16-step booking operational lifecycle and atomic database transaction boundaries**, concurrency locking, booking reference generation, duplicate submission prevention (idempotency), and the state machines governing bookings and payments.

---

## 2. Scope
* **In Scope:** Passenger checkout orchestration, atomic database transaction boundaries, pessimistic concurrency lock acquisition, instant confirmation mechanics, idempotency tokens, reference generation, and status lifecycles for MVP.
* **Out of Scope:** Online gateway webhook listeners, automated refund chargebacks, and asynchronous waiting lists.

---

## 3. Relevant Requirements

| ID | Requirement Description | Classification | Notes |
|---|---|---|---|
| BWF-01 | **Instant Booking Model** | **`[CONFIRMED]`** | Booking is immediately confirmed upon atomic commit. No rider or operator approval. |
| BWF-02 | **16-Step Booking Operational Lifecycle** | **`[CONFIRMED]`** | Structured into pre-transaction checks, atomic database transaction, and post-commit actions. |
| BWF-03 | **Independent Booking vs. Payment Status** | **`[CONFIRMED]`** | Booking is `confirmed` upon reservation; payment remains `unpaid` until physical cash collection. |
| BWF-04 | **Unique Booking Reference Code** | **`[CONFIRMED]`** | Human-readable unique alphanumeric reference (e.g., `OT-2026-X7K9`). |
| BWF-05 | **Rollback Safety** | **`[CONFIRMED]`** | Any transaction error causes 100% rollback of all records and locks. |
| BWF-06 | **Duplicate Submission Idempotency** | **`[CONFIRMED]`** | Protection against double-clicking and network retries via client idempotency keys. |
| BWF-07 | **Passenger Manual Seat Choice** | **`[CONFIRMED]`** | Passenger manually selects seat; system never silently assigns another seat. |

---

## 4. The Instant Booking Architecture

Unlike ridesharing platforms where drivers must manually accept or reject trip requests, Oliver Transport functions as an **intercity scheduled shuttle service**. 

```mermaid
stateDiagram-v2
    [*] --> FormSubmitted: Passenger Submits Booking Form
    
    state "Atomic DB Transaction (16 Steps)" as Tx {
        FormSubmitted --> Validating: Steps 1-5 (Auth, Trip, Stops, Seq, Seat)
        Validating --> Locking: Step 6 (Acquire DB Row Lock FOR UPDATE)
        Locking --> RecheckingVacancy: Step 7 (Recheck Segment Overlap under Lock)
        RecheckingVacancy --> PricingResolution: Steps 8-10 (Resolve Base Fare, Validate Coupon, Calc Final Fare)
        PricingResolution --> PersistingRecords: Steps 11-14 (Insert Booking, Seat, Payment, Coupon Usage)
        PersistingRecords --> Committing: Step 15 (DB::commit)
    }

    Committing --> Confirmed: Step 16 (Return Confirmation Voucher)
    RecheckingVacancy --> ConflictError: Overlap Detected (Rollback)
    PricingResolution --> ValidationError: Coupon Invalid (Rollback)
    
    ConflictError --> [*]: Return HTTP 409 Conflict (Prompt to Pick Another Seat)
    ValidationError --> [*]: Return HTTP 422 Unprocessable

    Confirmed --> InProgress: Rider Starts Trip Run
    InProgress --> Completed: Rider Completes Run & Collects Cash
    Confirmed --> Cancelled: Operator/Customer Cancels (Subject to Policy)
```

---

## 5. The 16-Step Booking Operational Lifecycle & Transaction Boundaries

The booking reservation process is structured into three distinct architectural stages. To ensure data consistency and prevent database lock exhaustion, only transactional data mutations execute inside the database transaction boundary.

```
+-----------------------------------------------------------------------------+
| STAGE A: PRE-TRANSACTION CHECKS (Outside DB Transaction)                    |
| - Authenticate passenger session                                            |
| - Authorize user role ('passenger')                                         |
| - Validate HTTP request format & payload                                    |
| - Validate / check idempotency token in cache                               |
+-----------------------------------------------------------------------------+
                                       |
                                       v
+-----------------------------------------------------------------------------+
| STAGE B: DATABASE TRANSACTION (DB::beginTransaction() -> DB::commit())      |
| - Validate trip & schedule state (cutoff check conditional on approval)     |
| - Validate boarding & drop-off stops and forward sequence                   |
| - Validate selected seat belongs to vehicle and is not driver seat          |
| - Acquire pessimistic row lock on vehicle_seats (SELECT ... FOR UPDATE)     |
| - Recheck segment availability under lock (zero overlap)                    |
| - Resolve applicable base fare (strictly per_trip model)                    |
| - Lock & validate coupon when supplied (SELECT ... FOR UPDATE on coupons)   |
| - Calculate final fare using safe integer-cents arithmetic                  |
| - Create booking record with reference OT-YYYY-XXXX                         |
| - Create booking-seat allocation record                                     |
| - Create unpaid cash payment record                                         |
| - Record coupon usage & increment usage counters when applicable            |
| - Commit database transaction (DB::commit())                                |
+-----------------------------------------------------------------------------+
                                       |
                                       v
+-----------------------------------------------------------------------------+
| STAGE C: POST-COMMIT ACTIONS (Outside DB Transaction)                       |
| - Dispatch domain events (BookingConfirmed)                                 |
| - Deliver HTTP confirmation response / redirect to digital boarding pass    |
+-----------------------------------------------------------------------------+
```

### Detailed 16-Step Operational Sequence

| Step # | Stage | Operation | Description | Failure Behavior |
|:---:|---|---|---|---|
| **1** | **Stage A: Pre-Transaction** | **Authenticate Passenger Session** | Verify active session and user identity. Authentication is an HTTP/session-level check, not a database-atomic operation. | `HTTP 401 Unauthorized` |
| **2** | **Stage A: Pre-Transaction** | **Authorize Role** | Enforce that the authenticated user has the `passenger` role (`RoleMiddleware`). Authorization precedes database mutations. | `HTTP 403 Forbidden` |
| **3** | **Stage A: Pre-Transaction** | **Validate Request Format & Payload** | Validate request parameters via `BookingRequest` (trip ID, stop IDs, seat ID, coupon string format). | `HTTP 422 Unprocessable` |
| **4** | **Stage A: Pre-Transaction** | **Validate Idempotency Token** | Check client UUID idempotency token against cache lock to prevent duplicate concurrent submissions. | `HTTP 409 Conflict` |
| **5** | **Stage B: DB Transaction** | **Validate Trip & Schedule State** | Inside transaction (`DB::beginTransaction()`): verify `trip_id` exists and is scheduled. No cutoff gate enforced in MVP (`[CONFIRMED]`). | Rollback → `HTTP 422 Unprocessable` |
| **6** | **Stage B: DB Transaction** | **Validate Stops & Forward Sequence** | Verify boarding and drop-off stops belong to route and enforce `boarding.stop_sequence < dropoff.stop_sequence`. | Rollback → `HTTP 422 Unprocessable` |
| **7** | **Stage B: DB Transaction** | **Validate Seat Association & Type** | Confirm all requested `vehicle_seat_ids` belong to assigned vehicle and are bookable (`is_driver_seat == 0`). | Rollback → `HTTP 422 Unprocessable` |
| **8** | **Stage B: DB Transaction** | **Acquire Pessimistic Row Lock on Seats** | Execute `SELECT * FROM vehicle_seats WHERE id IN (...) FOR UPDATE` on all selected physical seat rows. | Lock wait / Timeout |
| **9** | **Stage B: DB Transaction** | **Recheck Segment Overlap Under Lock** | Re-evaluate interval overlap math under row locks for all selected seats. If any is occupied, abort immediately; never silently auto-assign alternate seat. | Rollback → `HTTP 409 Conflict` |
| **10** | **Stage B: DB Transaction** | **Resolve Applicable Per-Trip Fare** | Authoritative resolution of flat base fare ($55.00 promo or $65.00 regular CAD) multiplied by seat count (`base_fare * count(seats)`). | Exception → Rollback |
| **11** | **Stage B: DB Transaction** | **Lock & Validate Coupon (If Supplied)** | If coupon provided: acquire row lock on coupon; verify active dates, minimum spend, global and per-user usage limits. | Rollback → `HTTP 422 Unprocessable` |
| **12** | **Stage B: DB Transaction** | **Calculate Final Net Fare** | Deduct percentage or fixed discount from total gross fare using safe integer-cents arithmetic. Ensure net total $\ge \$0.00$. | Exception → Rollback |
| **13** | **Stage B: DB Transaction** | **Create Booking Record** | Generate unique reference code (`OT-YYYY-XXXX`) and insert row into `bookings` table with `seat_count` and immutable financial snapshot. | Exception → Rollback |
| **14** | **Stage B: DB Transaction** | **Create Booking-Seat Allocations** | Insert rows into `booking_seats` recording `(booking_id, trip_id, vehicle_seat_id, boarding_sequence, dropoff_sequence)` for each seat. | Exception → Rollback |
| **15** | **Stage B: DB Transaction** | **Create Cash Payment & Record Coupon** | Insert row into `payments` (`status = 'unpaid'`, amount = `final_fare`). If coupon redeemed, update `coupons.current_uses` and insert `coupon_usages` row. | Exception → Rollback |
| **16** | **Stage B: DB Transaction** | **Commit Database Transaction** | Execute `DB::commit()`. Releases all row locks; atomically persists booking, seats, payment, and coupon records. | Exception → Rollback |

### Post-Commit Actions (Stage C — Outside Transaction)
* **Post-Commit Event Dispatch:** `Event::dispatch(new BookingConfirmed($booking))` executes strictly *after* successful transaction commit. Post-commit notification dispatch is decoupled and non-blocking.
* **Client Response Delivery:** Controller receives confirmed booking DTO and responds with `HTTP 201 Created` or redirects passenger to `/passenger/bookings/{reference}` to display the digital boarding pass.

---

## 6. Detailed Sequence Diagram

```mermaid
sequenceDiagram
    autonumber
    actor P as Passenger
    participant Ctrl as BookingController
    participant Svc as BookingService
    participant Avail as SeatAvailabilityService
    participant Pricing as PricingService
    participant Coupon as CouponService
    participant DB as MySQL Database
    participant Events as Event Dispatcher

    P->>Ctrl: POST /passenger/bookings (trip_id, seat_id, stops, coupon, idempotency_key)
    
    rect rgb(240, 244, 248)
        Note over Ctrl: STAGE A: PRE-TRANSACTION CHECKS (Outside DB Transaction)
        Ctrl->>Ctrl: Step 1: Authenticate session
        Ctrl->>Ctrl: Step 2: Authorize role ('passenger')
        Ctrl->>Ctrl: Step 3: Validate request payload format
        Ctrl->>Ctrl: Step 4: Validate / lock idempotency key in cache
    end

    Ctrl->>Svc: createBooking(BookingDataDTO)
    
    rect rgb(230, 245, 230)
        Note over Svc,DB: STAGE B: DATABASE TRANSACTION (DB::beginTransaction -> commit)
        Svc->>DB: DB::beginTransaction()
        Svc->>DB: Step 5: Validate trip exists & scheduled (cutoff check conditional)
        Svc->>DB: Step 6: Validate stops & sequence (boarding < dropoff)
        Svc->>DB: Step 7: Validate seat belongs to vehicle & is_driver_seat = 0
        Svc->>DB: Step 8: SELECT * FROM vehicle_seats WHERE id = ? FOR UPDATE
        Svc->>Avail: Step 9: Recheck segment availability under lock
        Avail->>DB: Query overlapping booking_seats
        alt Seat Claimed on Overlapping Segment Concurrently
            Svc->>DB: DB::rollBack()
            Svc-->>Ctrl: throw SeatUnavailableException
            Ctrl-->>P: HTTP 409 Conflict ("Seat taken; please pick another seat")
        end
        Svc->>Pricing: Step 10: Resolve base fare ($55 or $65 CAD, per_trip)
        opt Coupon Supplied
            Svc->>Coupon: Step 11: Validate & lock coupon under lock
            alt Coupon Invalid or Limit Exceeded
                Svc->>DB: DB::rollBack()
                Svc-->>Ctrl: throw CouponValidationException
                Ctrl-->>P: HTTP 422 Unprocessable ("Coupon invalid or exhausted")
            end
        end
        Svc->>Svc: Step 12: Calculate final fare (Integer Cents)
        Svc->>DB: Step 13: INSERT INTO bookings (OT-YYYY-XXXX, status='confirmed')
        Svc->>DB: Step 14: INSERT INTO booking_seats (boarding_seq, dropoff_seq)
        Svc->>DB: Step 15: INSERT INTO payments (unpaid, cash) & coupon_usages
        Svc->>DB: Step 16: DB::commit() (Releases row locks, persists state)
    end

    rect rgb(255, 250, 235)
        Note over Svc,Events: STAGE C: POST-COMMIT ACTIONS (Outside DB Transaction)
        Svc->>Events: Event::dispatch(new BookingConfirmed($booking))
        Svc-->>Ctrl: Return confirmed Booking DTO
        Ctrl-->>P: 201 Created (Redirect to Boarding Pass Voucher)
    end
```

---

## 7. Layered Architecture Implementation Standards

In accordance with Oliver Transport's service-oriented Laravel architecture, the booking workflow is partitioned across dedicated architectural layers to guarantee testability, maintainability, and zero business logic leakage.

### 7.1 Thin Controller Pattern

`Passenger\BookingController@store` is strictly an HTTP coordinator. It:
1. Receives validated, sanitized data from `CreateBookingRequest`.
2. Passes validated input to the injected `BookingService`.
3. Catches domain exceptions (`SeatUnavailableException`, `CouponValidationException`) and maps them to clean user responses.
4. Returns an HTTP redirect to the booking confirmation screen or JSON response.
5. Performs **zero** database queries, **zero** transaction calls, and **zero** pricing calculations.

```php
// app/Http/Controllers/Passenger/BookingController.php
namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookingRequest;
use App\Services\BookingService;
use App\Exceptions\SeatUnavailableException;
use App\Exceptions\CouponValidationException;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    public function store(CreateBookingRequest $request, BookingService $bookingService): RedirectResponse
    {
        try {
            $booking = $bookingService->createBooking(
                passenger: $request->user(),
                tripId: $request->validated('trip_id'),
                seatIds: $request->validated('vehicle_seat_ids'),
                boardingStopId: $request->validated('boarding_stop_id'),
                dropoffStopId: $request->validated('dropoff_stop_id'),
                couponCode: $request->validated('coupon_code'),
                idempotencyKey: $request->validated('idempotency_key')
            );

            return redirect()->route('passenger.bookings.show', $booking->booking_reference)
                ->with('success', 'Your seats have been reserved successfully!');
        } catch (SeatUnavailableException $e) {
            return back()->withInput()->withErrors(['vehicle_seat_ids' => 'One or more selected seats are no longer available. Please choose available seats.']);
        } catch (CouponValidationException $e) {
            return back()->withInput()->withErrors(['coupon_code' => $e->getMessage()]);
        }
    }
}
```

### 7.2 Form Request Validation (`CreateBookingRequest`)

All Stage A pre-transaction validation rules reside in `CreateBookingRequest`:
* **User Authorization:** Validates `auth()->check()` and `$user->hasRole('passenger')`.
* **Field Integrity:** Validates `trip_id`, `vehicle_seat_ids` (array, min: 1, max: 6, distinct, exists:vehicle_seats,id), `boarding_stop_id`, `dropoff_stop_id`, `coupon_code` (nullable, uppercase), and `idempotency_key` (UUID).
* **Stop Sequence Sanity:** Validates that `boarding_stop_id != dropoff_stop_id`.
* **Duplicate Submission Guard:** Checks session/cache lock for the given `idempotency_key`.

### 7.3 Service-Owned Transaction & Domain Orchestration

`BookingService` is the transactional boundary. It coordinates domain services and encapsulates the atomic database transaction:
* Injects `SeatAvailabilityService`, `PricingService`, `CouponService`, and `NotificationService`.
* Initiates `DB::beginTransaction()`, acquires row locks (`lockForUpdate()`), executes Steps 5–15, and executes `DB::commit()`.
* Automatically triggers `DB::rollBack()` on any unhandled exception or constraint violation.
* Dispatches `BookingConfirmed` strictly *after* `DB::commit()`.

### 7.4 Mandatory Eager Loading on Confirmation Views

When rendering the confirmation view (`passenger.bookings.show`), the controller must explicitly eager load all related models to enforce `NFR-13` (Zero N+1 queries):

```php
public function show(string $reference, BookingService $bookingService)
{
    $booking = $bookingService->getPassengerBookingByReference(auth()->user(), $reference);
    
    // Explicit eager loading before passing to Blade:
    $booking->loadMissing([
        'trip.route.stops',
        'trip.vehicle',
        'bookingSeats.vehicleSeat',
        'payment',
        'coupon'
    ]);

    return view('passenger.bookings.show', compact('booking'));
}
```

---

## 8. Booking Reference Generation & Idempotency

### 8.1 Unique Reference Code Algorithm
Booking references are customer-facing identifiers formatted as `OT-YYYY-XXXX`:
* **Prefix:** `OT-` (Oliver Transport)
* **Year:** 4-digit calendar year (e.g., `2026`)
* **Random Entropy:** 4-character uppercase alphanumeric string generated from a restricted character set:
  * Allowed: `23456789ABCDEFGHJKLMNPQRSTUVWXYZ`
  * Excluded ambiguous characters: `0` (zero), `O` (letter O), `1` (one), `I` (capital I).
* **Collision Handling:** Generated inside a retry loop (up to 3 attempts) verifying uniqueness against `bookings.booking_reference`.

### 8.2 Duplicate Submission Prevention (Idempotency)
To prevent accidental double bookings caused by double-clicking the confirmation button or intermittent mobile network retries:
1. **Frontend Submit Guard:** Submit button disables immediately upon first click and renders a loading spinner.
2. **Client Idempotency Key:** The booking form generates a unique UUID `idempotency_key` stored in the session/form.
3. **Backend Idempotency Cache:**
   ```php
   $lockKey = "booking_submission:{$user->id}:{$request->idempotency_key}";
   $acquired = Cache::add($lockKey, true, now()->addSeconds(30));
   
   if (! $acquired) {
       throw new DuplicateBookingSubmissionException("Booking is already being processed.");
   }
   ```

---

## 9. Status State Machines

### 9.1 Booking Lifecycle State Machine
* **`confirmed`:** Default status upon successful transaction commit. Indicates a guaranteed seat reservation.
* **`completed`:** Transitioned when the dated trip has concluded and the passenger reached their destination.
* **`cancelled`:** Indicates the booking was cancelled (subject to approved cancellation rules). Releasing the seat segment allows other travelers to book it.

### 9.2 Payment Lifecycle State Machine
* **`unpaid`:** Initial state for all cash bookings upon confirmation.
* **`paid`:** Transitioned when the assigned Rider physically receives cash from the passenger and clicks "Collect Cash". Captures `collected_by` (Rider User ID) and `collected_at` (timestamp).

```
Booking Status:    [CONFIRMED] ------------> [COMPLETED]
                         |
                         +-----------------> [CANCELLED]

Payment Status:    [UNPAID] ----------------> [PAID]
```

---

## 10. Business Rules

* **BR-BWF-01 (Lock Scope):** Locks acquired during Step 6 must be released immediately upon transaction commit or rollback, minimizing lock wait timeouts.
* **BR-BWF-02 (External Side Effects):** Irreversible external side effects (e.g., logging external metrics or queued mail dispatch) must never be executed inside the critical database transaction block. They must listen to the post-commit `BookingConfirmed` event.
* **BR-BWF-03 (No Silent Seat Substitution):** If the selected seat becomes unavailable during Step 7, the system must immediately abort and inform the user. It must **never** auto-assign an alternate seat.

---

## 11. Related Documents
* [`03-functional-requirements.md`](./03-functional-requirements.md) — Functional specifications.
* [`07-database-design.md`](./07-database-design.md) — Table schemas and indexes.
* [`09-seat-management.md`](./09-seat-management.md) — Segment overlap calculation logic.
* [`10-coupon-and-pricing.md`](./10-coupon-and-pricing.md) — Per-trip pricing and coupon engine.
* [`workflows/passenger-booking.md`](./workflows/passenger-booking.md) — Step-by-step passenger checkout journey.
