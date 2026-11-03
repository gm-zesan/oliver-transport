# ADR-002: Cash-Only Settlement & Independent Payment Lifecycle

## Status
**ACCEPTED** (Architectural Standard)

## Date
2026-11-03

## Context
Oliver Transport operates initially as a cash-only passenger shuttle service. Passengers book seats online in advance, but physical payment occurs in Canadian cash upon boarding the vehicle. Online credit card processing gateways (Stripe, Moneris) are explicitly excluded from the MVP to reduce development overhead, merchant fees, and PCI-DSS compliance scope.

In many systems, booking status and payment status are conflated into a single status field (e.g., `status = 'paid'`). In our business model, this conflation would create serious operational ambiguity:
* An online booking is confirmed immediately to guarantee the passenger's seat reservation, yet zero cash has been collected.
* If the booking status were marked `pending_payment`, automated cleanup scripts might cancel the seat prematurely.
* If marked `completed`, the system would falsely report that cash had been collected.

## Decision
We establish a strict architectural **separation between Booking Status and Payment Status**:

1. **Independent Relational Entities:**
   * The `bookings` table manages the reservation lifecycle: `'confirmed'`, `'completed'`, `'cancelled'`.
   * The `payments` table manages the financial settlement lifecycle: `'unpaid'`, `'paid'`.
2. **Instant Booking with Deferred Settlement:**
   * Upon successful checkout, the booking commits with `bookings.status = 'confirmed'` and `payments.status = 'unpaid'`.
   * The seat is officially reserved; no driver pre-approval is required.
3. **Physical Collection Audit Trail:**
   * The assigned Rider collects cash at the station and logs the action on the mobile manifest.
   * The system transitions `payments.status = 'paid'` and permanently logs `collected_by = rider_id` and `collected_at = timestamp`.

## Consequences

### Positive Consequences
* **Operational Clarity:** Clear distinction between having a reserved seat and having tendered cash.
* **Auditability:** Every collected dollar is tied to an authenticated Rider and exact timestamp.
* **Phase 3 Readiness:** When online payment gateways are introduced in Phase 3, the `payments` schema seamlessly accommodates credit card transaction IDs and webhooks without refactoring the `bookings` table.

### Negative / Trade-Off Consequences
* **No-Show Revenue Risk:** Passengers who book cash seats and fail to arrive cannot be charged automated cancellation fees in Phase 1.

