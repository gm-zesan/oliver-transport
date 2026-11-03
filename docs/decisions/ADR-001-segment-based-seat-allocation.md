# ADR-001: Segment-Based Seat Allocation vs. Trip-Wide Boolean

## Status
**ACCEPTED** (Architectural Standard)

## Date
2026-11-03 (Audited & Reconciled)

## Context
Oliver Transport operates scheduled intercity routes with intermediate stations:
* **Route A (Montreal → Toronto):** Montreal (`0`) → Yorkdale Mall (`1`) → Yonge Station (`2`).
* **Route B (Toronto → Montreal):** Yorkdale Mall (`0`) → Yonge Station (`1`) → Montreal (`2`).

In a standard shuttle bus model, a passenger traveling from Montreal to Yorkdale vacates the vehicle at Stop 1. At that point, another passenger can board at Yorkdale and travel to Yonge Station occupying that exact same physical seat.

If the application utilizes a simplistic trip-wide flag (such as `is_booked = true` on the seat or trip level), two major failures occur:
1. **Severe Under-Allocation:** The seat becomes permanently locked for the entire duration of the trip, preventing valid non-overlapping bookings and causing significant lost revenue.
2. **Catastrophic Double-Booking:** If an engineer attempts to remove the global lock without interval sequence tracking, two passengers will be permitted to book the seat for overlapping intervals (e.g., both riding between Yorkdale and Yonge), resulting in severe physical operational failure.

Furthermore, standard relational database unique indexes (such as `UNIQUE(trip_id, seat_id)`) cannot validate interval overlaps because they only detect scalar equality, not range intersection.

## Decision
We reject simplistic trip-wide boolean flags. We adopt a **Segment-Based Seat Allocation Model** with the following technical implementation:

1. **Relational Representation:**
   * An explicit entity `booking_seats` binds a `booking_id`, `trip_id`, `vehicle_seat_id`, `boarding_sequence` (integer), and `dropoff_sequence` (integer).
2. **Mathematical Interval Overlap Theorem:**
   Two journey intervals $A [B_A, D_A)$ and $B [B_B, D_B)$ on the same physical seat overlap if and only if:
   $$\text{Overlap} \iff (B_A < D_B) \land (B_B < D_A)$$
3. **Pessimistic Concurrency Serialization:**
   During Step 6 of the 16-step booking transaction, the application consistently acquires an exclusive pessimistic row lock on the target physical seat:
   ```sql
   SELECT * FROM vehicle_seats WHERE id = :vehicle_seat_id FOR UPDATE;
   ```
   The availability check is executed strictly *after* this lock is granted. If an overlap is detected, the transaction rolls back cleanly with `HTTP 409 Conflict`, prompting the user to select another seat.
4. **Manual Seat Choice Policy:**
   Passengers manually choose their preferred seat. If the chosen seat is taken concurrently, the system **never silently auto-assigns an alternate seat**.

## Consequences

### Positive Consequences
* **Zero Overbooking:** Completely eliminates the possibility of two passengers claiming the same seat on overlapping route segments.
* **Maximized Fleet Utilization:** Allows legitimate non-overlapping seat reuse (e.g., Passenger A rides Montreal → Yorkdale; Passenger B rides Yorkdale → Yonge on Seat S1).
* **Database Portability:** Relies on standard relational SQL operators (`<`, `AND`), ensuring full compatibility with MySQL 8.0 without requiring specialized GIS spatial extensions.

### Negative / Trade-Off Consequences
* **Query Complexity:** Availability checks require joining `booking_seats` and evaluating sequence inequalities rather than querying a simple boolean column.
* **Lock Contention:** Concurrent booking attempts for the same seat must serialize at the database level, slightly increasing latency under high contention (mitigated by index optimization).
