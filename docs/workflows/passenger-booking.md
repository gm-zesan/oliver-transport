# Workflow: Passenger Booking & Checkout

## 1. Workflow Purpose
This document specifies the streamlined **9-step customer booking journey**, detailing user interactions, mobile-first touch UX, real-time segment availability checks, promotional coupon validation, the **16-step booking operational lifecycle and atomic database transaction execution**, and boarding pass voucher generation for Oliver Transport.

---

## 2. Participants
* **Passenger:** Authenticated customer using desktop or mobile web browser.
* **Booking Controller (`BookingController`):** Manages view rendering and checkout submissions.
* **Seat Availability Service (`SeatAvailabilityService`):** Queries and evaluates segment availability.
* **Pricing Service (`PricingService`):** Resolves per-trip base rates ($55 / $65 CAD).
* **Coupon Service (`CouponService`):** Validates and calculates percentage or fixed discount amounts.
* **Booking Service (`BookingService`):** Coordinates pre-transaction checks, executes the atomic database transaction, and triggers post-commit actions.
* **Database (MySQL InnoDB):** Manages rows, constraints, and pessimistic row locks.

---

## 3. Comprehensive Sequence Diagram

```mermaid
sequenceDiagram
    autonumber
    actor P as Passenger
    participant Web as Booking Interface
    participant Ctrl as BookingController
    participant Svc as BookingService
    participant Avail as SeatAvailabilityService
    participant Pricing as PricingService
    participant Coupon as CouponService
    participant DB as MySQL Database

    P->>Web: 1. Selects Route Direction & Travel Date
    Web->>Ctrl: GET /api/trips/available?direction=...&date=...
    Ctrl->>DB: Query Dated Trip & Schedules
    DB-->>Web: Returns Trip ID, Departure Time (6:30 AM), Stop List
    
    P->>Web: 2. Selects Boarding Hub & Drop-off Hub
    Web->>Ctrl: GET /api/trips/{trip}/seats?from={id}&to={id}
    Ctrl->>Avail: evaluateSegmentAvailability(trip, fromSeq, toSeq)
    Avail->>DB: Query conflicting booking_seats
    DB-->>Avail: Overlap Results
    Avail-->>Web: Array of Seats [S1: true, S2: false, S3: true...]
    Web-->>P: Displays Visual Cabin (Vacant vs Occupied)
    
    P->>Web: 3. Clicks Preferred Available Seat (e.g., S1)
    Web-->>P: Highlights S1 in Electric Green
    
    opt Optional Promotional Coupon
        P->>Web: 4. Enters Coupon Code (e.g., "LAUNCH10")
        Web->>Ctrl: POST /api/coupons/validate
        Ctrl->>Coupon: validateCode(code, user, baseFare)
        Coupon-->>Web: Discount: $5.50 CAD | Net Fare: $49.50 CAD
    end

    P->>Web: 5. Clicks "Confirm Cash Booking"
    Web->>Ctrl: POST /passenger/bookings (trip_id, seat_id, stops, coupon, idempotency_key)
    
    rect rgb(240, 244, 248)
        Note over Ctrl: Stage A: Pre-Transaction Checks (Outside DB Transaction)
        Ctrl->>Ctrl: Steps 1-4: Authenticate, Authorize Role, Validate Request Format, Validate Idempotency Token
    end

    Ctrl->>Svc: createBooking(BookingDataDTO)
    
    rect rgb(230, 245, 230)
        Note over Svc,DB: Stage B: Database Transaction Boundary (DB::beginTransaction -> commit)
        Svc->>DB: DB::beginTransaction()
        Svc->>DB: Step 5: Validate trip exists & scheduled (cutoff check conditional)
        Svc->>DB: Step 6: Validate stops & sequence (boarding < dropoff)
        Svc->>DB: Step 7: Validate seat belongs to vehicle & is_driver_seat = 0
        Svc->>DB: Step 8: SELECT * FROM vehicle_seats WHERE id = ? FOR UPDATE
        Svc->>Avail: Step 9: isSeatAvailable(trip_id, seat_id, from_seq, to_seq)
        alt Seat Taken Concurrently
            Svc->>DB: DB::rollBack()
            Svc-->>Web: 409 Conflict ("Seat taken; please pick another seat")
        end
        Svc->>Pricing: Step 10: Resolve per_trip Base Fare ($55 or $65 CAD)
        opt Coupon Provided
            Svc->>Coupon: Step 11: Validate Coupon under Lock
        end
        Svc->>Svc: Step 12: Calculate Final Fare (Integer Cents)
        Svc->>DB: Step 13: Insert Booking Record (Reference: OT-2026-X8K2)
        Svc->>DB: Step 14: Insert Booking-Seat Allocation (Segment Range)
        Svc->>DB: Step 15: Insert Cash Payment Record (Status: Unpaid) & Coupon Usage
        Svc->>DB: Step 16: DB::commit() (Persists state, releases locks)
    end

    rect rgb(255, 250, 235)
        Note over Svc,Web: Stage C: Post-Commit Actions (Outside DB Transaction)
        Svc-->>Ctrl: Confirmed Booking Entity
        Ctrl-->>Web: Redirect to /passenger/bookings/OT-2026-X8K2
        Web-->>P: Displays Boarding Pass Voucher with QR Code
    end
```

---

## 4. The Extremely Simple 9-Step Passenger Booking Journey

The customer-facing booking journey is engineered for absolute clarity and speed:

| Step # | User Action | System Processing | UI Feedback (Mobile-First / iOS Safari) |
|:---:|---|---|---|
| **1** | **Open Site** | Evaluates active schedules and rolling 14-day trip window (`trips` table). | Fast-loading homepage with schedule and fixed per-trip pricing. |
| **2** | **Log In / Register** | Authenticates session via universal `/login` with role inspection. | Clean auth interface; 16px input font to prevent iOS auto-zoom. |
| **3** | **Find Trip** | Queries `trips` and `routes` filtered by date and active status. | Prominent dual-segment direction toggle and interactive calendar. |
| **4** | **View Trip Info** | Loads `route_stops`, scheduled times, and vehicle capacity metadata. | Card displays fixed departure time (6:30 AM) and executive 6-seat van. |
| **5** | **Select Stops** | Validates forward stop sequence constraint: $\text{Seq}(\text{board}) < \text{Seq}(\text{drop})$. | Simple dropdowns/radio pills for pickup and drop-off hubs. |
| **6** | **Choose Seat Visually** | Evaluates segment overlap query: $\text{Overlap} \iff (B_A < D_B) \land (B_B < D_A)$. | Cabin diagram with approximately 48 × 48 CSS pixels or larger tap targets; manual choice enforced. |
| **7** | **Review Fare & Coupon** | Validates coupon rules (expiry, spend, limits) and executes integer-cents arithmetic. | Flat $55 promo or $65 regular CAD per-trip summary; coupon input. |
| **8** | **Confirm Booking** | Executes 16-step booking operational lifecycle across Stage A, Stage B, and Stage C. | "Confirm Reservation" button disables to prevent double submissions. |
| **9** | **View Boarding Pass** | Generates digital boarding pass with reference code and cash payment notice. | Instant voucher with `OT-YYYY-XXXX`, seat number, and station details. |

---

### 4.1 Frontend Simplicity vs. Backend Robustness

| Frontend 9-Step Customer Journey | Backend 16-Step Operational Lifecycle & Transaction Boundaries |
|---|---|
| **Step 1: Open Site** | Evaluates active schedules and rolling 14-day trip window (`trips` table). |
| **Step 2: Log In / Register** | Authenticates session via universal `/login` with role inspection. |
| **Step 3: Find Trip** | Queries `trips` and `routes` filtered by date and active status. |
| **Step 4: View Trip Info** | Loads `route_stops`, scheduled times, and vehicle capacity metadata. |
| **Step 5: Select Stops** | Validates forward stop sequence constraint: $\text{Seq}(\text{board}) < \text{Seq}(\text{drop})$. |
| **Step 6: Choose Seat Visually** | Evaluates segment overlap query: $\text{Overlap} \iff (B_A < D_B) \land (B_B < D_A)$. Target approximately 48 × 48 CSS pixels or larger for seat tiles. |
| **Step 7: Review Fare & Coupon** | Validates coupon rules (expiry, spend, limits) and executes integer-cents arithmetic. |
| **Step 8: Confirm Booking** | **16-Step Operational Execution Across 3 Stages:**<br/>**Stage A: Pre-Transaction Checks (Outside DB Transaction):**<br/>1. Authenticate passenger session.<br/>2. Authorize role (`passenger`).<br/>3. Validate request format & parameters.<br/>4. Check client idempotency key in cache.<br/>**Stage B: Database Transaction (`DB::beginTransaction()` to `DB::commit()`):**<br/>5. Validate trip & schedule (departure cutoff check conditional on client approval).<br/>6. Validate stops & forward sequence.<br/>7. Validate seat belongs to vehicle & `is_driver_seat == 0`.<br/>8. `SELECT * FROM vehicle_seats WHERE id = ? FOR UPDATE` (Pessimistic Row Lock).<br/>9. Re-verify segment overlap under lock.<br/>10. Resolve applicable `per_trip` base fare.<br/>11. Re-validate & lock coupon row (if supplied).<br/>12. Calculate final net fare in integer cents.<br/>13. Insert `bookings` record (`OT-YYYY-XXXX`).<br/>14. Insert `booking_seats` segment allocation.<br/>15. Insert `payments` cash record (`status = 'unpaid'`) & record coupon usage.<br/>16. Commit database transaction (`DB::commit()`).<br/>**Stage C: Post-Commit Actions (Outside DB Transaction):**<br/>- Dispatch domain events (`BookingConfirmed`) after commit.<br/>- Deliver HTTP response / redirect. |
| **Step 9: View Boarding Pass** | Renders digital boarding pass with reference code and cash payment notice. |

---

## 5. Concurrency Race Condition Handling
If two users select Seat S1 simultaneously:
1. User A's transaction acquires the row lock on `vehicle_seats` first (Step 6).
2. User B's transaction pauses until User A commits.
3. User B's transaction acquires the lock, rechecks vacancy (Step 7), discovers User A's booking overlapping the segment, and rolls back cleanly.
4. User B receives an `HTTP 409 Conflict` message: *"Seat S1 was just booked by another traveler. Please choose another available seat."*
5. The visual seat picker automatically refreshes, marking S1 as unavailable.
6. **The system never auto-assigns an alternate seat.**

---

## 6. Related Documents
* [`08-booking-workflow.md`](../08-booking-workflow.md) — 16-step transaction architecture.
* [`09-seat-management.md`](../09-seat-management.md) — Segment overlap calculation logic.
* [`10-coupon-and-pricing.md`](../10-coupon-and-pricing.md) — Per-trip pricing and coupon rules.
