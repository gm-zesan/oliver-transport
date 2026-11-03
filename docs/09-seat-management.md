# 09 — Seat Management & Segment-Based Availability

## 1. Document Purpose
This document provides the definitive mathematical, algorithmic, and architectural specification for the **Oliver Transport Seat Management Engine**. It details the physical vehicle cabin layout, the visual seat selection interface, and specifies the **segment-based availability algorithm** that prevents overbooking while maximizing vehicle utilization across multi-stop routes.

---

## 2. Scope
* **In Scope:** Vehicle cabin configuration (6 passenger seats), physical seating chart rendering, manual passenger seat choice, mathematical interval-overlap conflict detection, concurrency row-locking strategies, and boundary condition verification for MVP.
* **Out of Scope:** Dynamic seating configuration re-architecting, multi-vehicle fleet seat balancing, and VIP reserved seat tiers.

---

## 3. Relevant Requirements

| ID | Seating Architecture Requirement | Classification | Specification Notes |
|---|---|---|---|
| SMA-01 | Single Vehicle Fleet with 6 Passenger Seats | **`[CONFIRMED]`** | S1 front passenger seat; S2 through S6 rear passenger cabin. |
| SMA-02 | Driver Seat Exclusion | **`[CONFIRMED]`** | Driver seating is permanently unbookable and excluded from passenger capacity. |
| SMA-03 | Realistic Visual Seat Selection Picker | **`[CONFIRMED]`** | Renders realistic cabin layout (front passenger + rear rows) rather than generic grid. |
| SMA-04 | **Segment-Based Seat Availability Model** | **`[CONFIRMED]`** | Seat occupancy evaluated strictly per journey sequence interval. |
| SMA-05 | Non-Overlapping Sequential Seat Reuse | **`[CONFIRMED]`** | Same seat can be booked by Passenger B after Passenger A departs. |
| SMA-06 | Concurrency-Safe Serialization | **`[CONFIRMED]`** | Transaction-level pessimistic row locking preventing race condition overbooking. |
| SMA-07 | **Manual Passenger Choice & No Silent Reassignment** | **`[CONFIRMED]`** | Passenger chooses physical seat. System never silently assigns another seat if taken. |

---

## 4. Physical Vehicle Seating Layout

The initial fleet consists of a single commercial passenger van configured for seven total cabin positions (1 Driver + 6 Bookable Passenger Seats).

### 4.1 Cabin Spatial Architecture

```
+-------------------------------------------------------------+
|                      [ ENGINE / HOOD ]                      |
+-------------------------------------------------------------+
|   [ DRIVER SEAT ]                 [ SEAT S1 ]               |
|   (Excluded / Not Bookable)       (Front Passenger Window)  |
+-------------------------------------------------------------+
|                     [ AISLE / ENTRYWAY ]                    |
+-------------------------------------------------------------+
|   [ SEAT S2 ]                                 [ SEAT S3 ]   |
|   (2nd Row Left Window)                       (2nd Row Right)|
+-------------------------------------------------------------+
|   [ SEAT S4 ]             [ SEAT S5 ]         [ SEAT S6 ]   |
|   (3rd Row Left Window)   (3rd Row Middle)    (3rd Row Right)|
+-------------------------------------------------------------+
|                       [ LUGGAGE BAY ]                       |
+-------------------------------------------------------------+
```

### 4.2 Visual UI States in the Seat Picker
* **Available (Unoccupied):** Clean neutral border, clickable, clear seat label (e.g., `S1`, `S2`).
* **Selected:** Highlighted with Oliver Transport electric green (`#00FF66`), dark text, checkmark icon. Displays summary below: *"Selected: Seat S1 (Front Passenger)"*.
* **Unavailable (Occupied on Segment):** Muted dark gray/slate background, disabled cursor, strikethrough icon, `aria-disabled="true"`.
* **Driver Seat:** Rendered as an unclickable steering wheel icon labeled "Driver (Excluded)".

### 4.3 Policy on Concurrent Collision & Reassignment
* **No Silent Auto-Assignment:** If another user reserves the passenger's selected seat while they are completing checkout, **the system must never silently assign another seat**.
* **User Feedback:** The system immediately aborts the transaction with `HTTP 409 Conflict`, displays a friendly error message (*"Seat S1 was just booked by another traveler. Please choose another available seat."*), and refreshes the seat picker so the passenger can pick another seat.

---

## 5. Critical Problem: Why Simple Boolean Availability Fails

Many naive booking systems utilize a simplistic boolean flag on trips or seats:

```sql
-- DANGEROUS / INADEQUATE DESIGN:
is_booked = true
```

### Why This Fails for Oliver Transport
Oliver Transport operates scheduled routes with intermediate stops:
* **Montreal → Toronto** has stops: Montreal (`0`), Yorkdale (`1`), Yonge Station (`2`).
* If Passenger 1 books **Montreal → Yorkdale** on Seat S1, marking S1 as `is_booked = true` for the whole trip would prevent Passenger 2 from booking **Yorkdale → Yonge Station** on S1, causing lost revenue.
* Conversely, if the system simply checks if S1 has *any* booking without checking the specific route segment, it will either under-allocate or cause **catastrophic double-booking** when Passenger 1 and Passenger 2 both board simultaneously.

---

## 6. The Segment-Based Availability Model

### 6.1 Route Stop Sequences
Every route consists of an ordered sequence of stations identified by an integer sequence index:

#### Route A: Montreal → Toronto (`MTL_TO_TOR`)
* `0`: Metro Namur (Montreal)
* `1`: Yorkdale Mall (Toronto)
* `2`: Yonge Station (Toronto)

#### Route B: Toronto → Montreal (`TOR_TO_MTL`)
* `0`: Yorkdale Mall (Toronto)
* `1`: Yonge Station (Toronto)
* `2`: Montreal Terminus

### 6.2 The Interval Overlap Mathematical Theorem
A passenger journey is an open-ended sequence interval $[B, D)$, where $B = \text{boarding sequence}$ and $D = \text{drop-off sequence}$, with $B < D$.

Two passenger journeys on the same physical seat, Journey $A [B_A, D_A)$ and Journey $B [B_B, D_B)$, **overlap if and only if**:

$$\text{Overlap} \iff (B_A < D_B) \land (B_B < D_A)$$

If $\text{Overlap}$ evaluates to **TRUE**, the two reservations conflict and cannot share the seat.
If $\text{Overlap}$ evaluates to **FALSE**, the journeys are adjacent or disjoint, and the seat **may be safely reused**.

```mermaid
graph TD
    subgraph NonOverlapping["Case 1: Sequential Non-Overlapping Bookings (ALLOWED)"]
        direction TB
        A1["Passenger 1: Montreal (0) -> Yorkdale (1)"]
        A2["Passenger 2: Yorkdale (1) -> Yonge Station (2)"]
        A1 -.->|"Drop-off at 1 == Boarding at 1 (No Overlap)"| A2
    end

    subgraph Overlapping["Case 2: Overlapping Booking Conflict (STRICTLY PROHIBITED)"]
        direction TB
        B1["Passenger 1: Montreal (0) -> Yonge Station (2)"]
        B2["Passenger 2: Yorkdale (1) -> Yonge Station (2)"]
        B1 ===|"Conflict on Segment (1 -> 2)!"|=== B2
    end
```

---

## 7. Concrete Journey Examples

### Example 1: Route A (Montreal → Toronto) — Sequential Reuse (ALLOWED)
* **Passenger 1:**
  * Boarding: Montreal (Sequence `0`)
  * Drop-off: Yorkdale Mall (Sequence `1`)
  * Seat: `S1`
  * Interval $A = [0, 1)$
* **Passenger 2:**
  * Boarding: Yorkdale Mall (Sequence `1`)
  * Drop-off: Yonge Station (Sequence `2`)
  * Seat: `S1`
  * Interval $B = [1, 2)$
* **Overlap Evaluation:**
  $$(B_A < D_B) \land (B_B < D_A) \implies (0 < 2) \land (1 < 1) \implies \text{TRUE} \land \text{FALSE} \implies \mathbf{FALSE}$$
* **Result:** **ALLOWED**. Passenger 2 boards at Yorkdale into the exact seat vacated by Passenger 1.

### Example 2: Route A (Montreal → Toronto) — Direct Overlap (BLOCKED)
* **Passenger 1:**
  * Boarding: Montreal (Sequence `0`)
  * Drop-off: Yonge Station (Sequence `2`)
  * Seat: `S1`
  * Interval $A = [0, 2)$
* **Passenger 2:**
  * Boarding: Yorkdale Mall (Sequence `1`)
  * Drop-off: Yonge Station (Sequence `2`)
  * Seat: `S1`
  * Interval $B = [1, 2)$
* **Overlap Evaluation:**
  $$(0 < 2) \land (1 < 2) \implies \text{TRUE} \land \text{TRUE} \implies \mathbf{TRUE}$$
* **Result:** **PROHIBITED**. Passenger 1 is already sitting in `S1` between Yorkdale and Yonge Station.

### Example 3: Route B (Toronto → Montreal) — Shared Trunk Overlap (BLOCKED)
* **Passenger 1:** Yorkdale Mall (`0`) → Montreal (`2`) on `S2`. Interval = $[0, 2)$
* **Passenger 2:** Yonge Station (`1`) → Montreal (`2`) on `S2`. Interval = $[1, 2)$
* **Overlap Evaluation:**
  $$(0 < 2) \land (1 < 2) \implies \text{TRUE} \land \text{TRUE} \implies \mathbf{TRUE}$$
* **Result:** **PROHIBITED**. Both passengers would claim Seat `S2` from Yonge Station to Montreal.

---

## 8. Technical Concurrency & Relational Constraints

### 8.1 Why Unique Indexes Cannot Solve Arbitrary Interval Overlaps Alone
A standard SQL unique index (e.g., `UNIQUE(trip_id, seat_id, boarding_sequence)`) only prevents identical pickup points. It cannot evaluate whether an existing booking spanning $[0, 2)$ overlaps with a new booking spanning $[1, 2)$.

Therefore, relational integrity requires a **two-tier defense**:
1. **Pessimistic Row Lock on Physical Seat:** In Step 6 of the booking transaction, acquire an exclusive row lock on `vehicle_seats`:
   ```sql
   SELECT * FROM vehicle_seats WHERE id = :vehicle_seat_id FOR UPDATE;
   ```
2. **Interval Overlap Conflict Query:** In Step 7, execute the conflict detection query under active lock:
   ```sql
   SELECT COUNT(*) AS conflict_count
   FROM booking_seats bs
   JOIN bookings b ON bs.booking_id = b.id
   WHERE bs.trip_id = :trip_id
     AND bs.vehicle_seat_id = :vehicle_seat_id
     AND b.status = 'confirmed'
     AND (
         bs.boarding_sequence < :requested_dropoff_sequence
         AND :requested_boarding_sequence < bs.dropoff_sequence
     );
   ```
   * If `conflict_count === 0`: The seat is completely vacant across the requested sequence interval.
   * If `conflict_count > 0`: The transaction rolls back immediately and throws `SeatUnavailableException`.

---

## 9. Layered Architecture Implementation Standards

To preserve architectural integrity, all seat availability logic, segment mathematics, and cabin inventory state are encapsulated within `SeatAvailabilityService`.

### 9.1 Service Boundary (`SeatAvailabilityService`)

Controllers, models, and Blade templates are strictly prohibited from performing segment interval calculations or executing conflict detection queries. All operations must route through `SeatAvailabilityService`:

```php
// app/Services/SeatAvailabilityService.php
namespace App\Services;

use App\Models\Trip;
use App\Models\VehicleSeat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SeatAvailabilityService
{
    /**
     * Returns cabin seat map with availability flags for a specific segment.
     */
    public function getSeatAvailabilityForSegment(Trip $trip, int $boardingSeq, int $dropoffSeq): Collection
    {
        // 1. Mandatory eager loading of vehicle seats (NFR-13)
        $seats = $trip->vehicle->seats()->orderBy('id')->get();

        // 2. Query occupied seat IDs on overlapping segment
        $occupiedSeatIds = DB::table('booking_seats')
            ->join('bookings', 'booking_seats.booking_id', '=', 'bookings.id')
            ->where('booking_seats.trip_id', $trip->id)
            ->where('bookings.status', 'confirmed')
            ->where('booking_seats.boarding_sequence', '<', $dropoffSeq)
            ->where('booking_seats.dropoff_sequence', '>', $boardingSeq)
            ->pluck('booking_seats.vehicle_seat_id')
            ->all();

        // 3. Map availability status onto seats collection
        return $seats->map(function (VehicleSeat $seat) use ($occupiedSeatIds) {
            $seat->is_available = ! in_array($seat->id, $occupiedSeatIds) && ! $seat->is_driver_seat;
            return $seat;
        });
    }

    /**
     * Executes segment conflict detection under active pessimistic row lock.
     */
    public function assertSeatAvailableUnderLock(int $tripId, int $seatId, int $boardingSeq, int $dropoffSeq): void
    {
        $hasConflict = DB::table('booking_seats')
            ->join('bookings', 'booking_seats.booking_id', '=', 'bookings.id')
            ->where('booking_seats.trip_id', $tripId)
            ->where('booking_seats.vehicle_seat_id', $seatId)
            ->where('bookings.status', 'confirmed')
            ->where('booking_seats.boarding_sequence', '<', $dropoffSeq)
            ->where('booking_seats.dropoff_sequence', '>', $boardingSeq)
            ->exists();

        if ($hasConflict) {
            throw new \App\Exceptions\SeatUnavailableException("The selected seat is occupied on this journey segment.");
        }
    }
}
```

### 9.2 Request Validation & Thin Controller Coordination

1. **Validation via Form Request:** When searching or requesting seats, `SearchTripRequest` and `CreateBookingRequest` validate stop IDs and enforce `boarding_stop_id != dropoff_stop_id` prior to controller invocation.
2. **Thin Controller Delegation:** `Passenger\TripController@seats` receives the validated request, calls `SeatAvailabilityService::getSeatAvailabilityForSegment(...)`, and passes the resulting collection to the Blade view.
3. **Mandatory Preloading:** The controller ensures `$trip->loadMissing(['route.stops', 'vehicle.seats'])` is executed before view rendering, guaranteeing zero N+1 database queries.

---

## 10. Comprehensive Testing Matrix (Boundary & Concurrency)

| Test Case ID | Scenario | Existing Booking | Requested Booking | Expected Outcome |
|---|---|---|---|:---:|
| **TC-SEAT-01** | Full route booking on empty seat | None | Montreal (`0`) → Yonge (`2`) | **Permitted** |
| **TC-SEAT-02** | Exact duplicate interval | Montreal (`0`) → Yorkdale (`1`) | Montreal (`0`) → Yorkdale (`1`) | **Rejected (Conflict)** |
| **TC-SEAT-03** | Sequential adjacent segment reuse | Montreal (`0`) → Yorkdale (`1`) | Yorkdale (`1`) → Yonge (`2`) | **Permitted** |
| **TC-SEAT-04** | Subset interval within full booking | Montreal (`0`) → Yonge (`2`) | Yorkdale (`1`) → Yonge (`2`) | **Rejected (Conflict)** |
| **TC-SEAT-05** | Superset interval covering active booking | Yorkdale (`1`) → Yonge (`2`) | Montreal (`0`) → Yonge (`2`) | **Rejected (Conflict)** |
| **TC-SEAT-06** | Reverse journey attempt | None | Yonge (`2`) → Montreal (`0`) | **Rejected (Invalid Seq)** |
| **TC-SEAT-07** | Same pickup and drop-off | None | Yorkdale (`1`) → Yorkdale (`1`) | **Rejected (Invalid Seq)** |
| **TC-SEAT-08** | Concurrency race condition | Empty seat | Two simultaneous requests for `[0, 2)` | **1 Succeeded, 1 Rejected (409)** |

---

## 11. Business Rules

* **BR-SMA-01 (Multiple Seats Supported Under 1 Account):** A passenger can select and reserve multiple physical seats (1 to 6 seats, up to available cabin capacity) in a single booking transaction using 1 account.
* **BR-SMA-02 (Seat Immutability):** Once a booking commits, its assigned seats cannot be changed by the passenger without contacting customer support.
* **BR-SMA-03 (Cancelled Seat Instant Release):** If a booking is cancelled by an operator, its `booking_seats` records are excluded from the conflict query (`b.status = 'confirmed'`), instantly returning the seat segments to the available inventory pool.
* **BR-SMA-04 (Zero Auto-Assignment):** The system must never silently assign an alternate seat if any selected seat is taken during checkout. If any chosen seat conflicts, the user is notified and prompted to pick available seats.

---

## 12. Related Documents
* [`06-system-architecture.md`](./06-system-architecture.md) — Service architecture and transaction boundaries.
* [`07-database-design.md`](./07-database-design.md) — Table schema for `booking_seats`.
* [`08-booking-workflow.md`](./08-booking-workflow.md) — 16-step booking transaction.
* [`16-testing-strategy.md`](./16-testing-strategy.md) — Automated concurrency test implementation.
