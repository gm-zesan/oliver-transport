# ADR-004: Comprehensive Pending Client Decisions Log

## Status
**PENDING REVIEW** (Awaiting Client Sign-Off)

## Date
2026-11-03 (Audited & Reconciled)

## Context
During the requirements analysis and architectural specification of Oliver Transport, several commercial and operational parameters were identified that require explicit client confirmation.

> [!IMPORTANT]
> In accordance with architectural governance rules, **a proposed default must NEVER become a confirmed requirement simply because it appears in multiple documents**. All items below are strictly classified using standard statuses:
> * **`[CONFIRMED]`**: Explicitly mandated and approved by the client.
> * **`[PENDING]`**: An unresolved commercial or operational decision requiring client direction.
> * **`[PROPOSED]`**: A technical or procedural default recommended by the architecture team to allow development to proceed without delay.
> * **`[FUTURE]`**: Explicitly excluded from MVP and reserved for subsequent phases.

---

## Comprehensive Registry of Pending Decisions & Proposed Defaults

### 1. Final Montreal Destination Address for Route B (Toronto → Montreal)
* **Context:** Route A departs Metro Namur (Montreal), with Toronto stops at Yorkdale Mall and Yonge Station.
* **Confirmed Decision:** **Station Métro Namur (Montreal)**. There are exactly three (3) stations in the entire system:
  1. **Station Métro Namur** (Montreal)
  2. **Yorkdale Mall** (Toronto)
  3. **Yonge Station** (Toronto)
* **Specification:** Route A (Montreal → Toronto): Métro Namur (6:30 AM) → Yorkdale Mall → Yonge Station. Route B (Toronto → Montreal): Yorkdale Mall (12:15 PM) → Yonge Station (1:15 PM) → Métro Namur.
* **Classification:** **`[CONFIRMED]`**

---

### 2. Vehicle Passenger Capacity & Seating Interpretation
* **Context:** Confirmation of the cabin seating allocation.
* **Specification:** 7 total cabin seats: 1 Driver seat (permanently excluded from passenger capacity and booking) + 6 Bookable Passenger Seats (S1 front passenger window + S2–S6 rear cabin). Vehicle is a commercial Honda Odyssey van (License Plate: "RAJIA").
* **Classification:** **`[CONFIRMED]`**

---

### 3. Promotional Launch Fare ($55 CAD) Expiration Date
* **Context:** The regular fare is confirmed as $65.00 CAD per passenger per trip, with an introductory launch fare of $55.00 CAD.
* **Proposed Default for MVP:** Configured in `config/pricing.php` with an active flag (`PRICING_PROMO_ACTIVE=true`). Runs indefinitely until manually toggled by the system operator.
* **Classification:** **`[PROPOSED]`**

---

### 4. Coupon Application: Multi-Seat Booking Discount Calculation
* **Context:** When multiple seats are booked in a single transaction, how are coupons applied?
* **Specification:**
  * **Percentage Coupons:** Applied against the total gross fare (e.g. 10% off 2 seats = 10% of $110.00 = $11.00 discount; Net = $99.00 CAD).
  * **Fixed Coupons:** Applied once per booking transaction (e.g. $10.00 off 2 seats = $10.00 discount off total gross fare; Net = $100.00 CAD). Net fare cannot be negative.
* **Classification:** **`[CONFIRMED]`**

---

### 5. Coupon Stacking Policy
* **Context:** Can a passenger combine multiple coupon codes on a single reservation?
* **Proposed Default for MVP:** **Zero Stacking**. Exactly one (1) coupon code may be entered per transaction. However, coupons *may* be applied against the active $55 promotional launch base fare unless explicitly restricted.
* **Classification:** **`[PROPOSED]`**

---

### 6. Default Coupon Eligibility & Usage Rules
* **Context:** What default constraints should apply to newly seeded coupons?
* **Proposed Default for MVP:** 
  * Maximum usage per passenger: `1`.
  * Minimum booking spend: `$0.00`.
  * Default expiration: 30 days from creation.
  * Currency: Strictly CAD.
* **Classification:** **`[PROPOSED]`**

---

### 7. Passenger Cancellation System
* **Context:** Client policy on booking cancellation.
* **Confirmed Decision:** **No Cancellation System in MVP**. Self-service cancellation is strictly excluded from the application. Once a booking is created, it is confirmed.
* **Specification:** Zero cancellation routes, controllers, or self-service cancellation buttons exist in the passenger UI. If a customer cannot travel, they contact customer service out-of-band via phone/SMS (`647-655-1884`) or Facebook (`Oliver Transport`). An operator can mark a booking cancelled in the database/backend if needed.
* **Classification:** **`[CONFIRMED — EXCLUDED FROM MVP]`**

---

### 8. Cancellation Deadline Threshold
* **Context:** What is the cancellation cutoff deadline?
* **Confirmed Decision:** **N/A for MVP**. Because no in-app cancellation system is introduced in MVP, no cutoff deadline logic is enforced.
* **Classification:** **`[CONFIRMED — N/A IN MVP]`**

---

### 9. Future Refund Policy Framework
* **Context:** In Phase 3 when online card payments are introduced, what refund percentage should be issued upon cancellation?
* **Proposed Default for Future:** Full refund if cancelled > 24 hours prior; 80% refund if cancelled 2–24 hours prior; zero refund if cancelled < 2 hours prior. In MVP, zero electronic refunds exist.
* **Classification:** **`[FUTURE]`**

---

### 10. Cash Collection & Confirmation Procedure
* **Context:** What is the physical procedure for logging cash collection?
* **Proposed Default for MVP:** The assigned Rider opens the mobile manifest at boarding, collects the cash, and taps the green "Collect Cash" button beside the passenger's name, permanently logging the collection.
* **Classification:** **`[PROPOSED]`**

---

### 11. Booking Cutoff Threshold Before Departure
* **Context:** At what point does booking close for an upcoming trip?
* **Confirmed Decision:** **No Cutoff System in MVP**. Bookings remain open up until departure time as long as available seats exist on the vehicle.
* **Specification:** The booking system does not reject reservations based on minutes prior to departure in MVP.
* **Classification:** **`[CONFIRMED — NO CUTOFF IN MVP]`**

---

### 12. Minimum Passenger Details Required for Booking
* **Context:** What personal data fields are mandatory to place a booking?
* **Specification:** Full Name, Valid Email Address, and Valid Canadian/E.164 Contact Phone Number. (Required for booking verification and driver manifest).
* **Classification:** **`[CONFIRMED]`**

---

### 13. Multiple Passengers / Seats per Booking
* **Context:** Can a passenger book multiple seats (e.g., 2 or more seats for family/friends) in a single transaction using 1 account?
* **Confirmed Decision:** **Multiple Seats Supported Under 1 Account (No Limit)**.
* **Specification:**
  * A passenger can select and reserve multiple physical seats (1 to 6 seats, up to vehicle capacity) in a single booking transaction.
  * Relational schema (`bookings` 1 → N `booking_seats`) allocates each selected seat to the booking reference.
  * Total Gross Fare = `base_fare * count(seats)`.
  * Net Cash Payable = `max(0, gross_fare - discount)`.
  * Concurrency Locking: `BookingService` acquires row locks on all requested `vehicle_seats` (`SELECT ... WHERE id IN (...) FOR UPDATE`). If any seat is taken on an overlapping segment, the entire transaction rolls back cleanly.
* **Classification:** **`[CONFIRMED]`**

---

### 14. Individual Seat Selection Requirement
* **Context:** Must passengers always choose their exact physical seat, or can they request "any available seat"?
* **Specification:** **Mandatory Visual Selection**. Passengers visually select one or more unoccupied seats (S1–S6) on the interactive vehicle diagram. The system never auto-assigns an alternate seat.
* **Classification:** **`[CONFIRMED]`**

---

### 15. Bilingual (English / French) Localization Requirement
* **Context:** Promotional materials exist in both English and French. Is full bilingual localization required for the MVP web release?
* **Confirmed Decision:** **English First, French Later**.
* **Specification:** MVP launches with English UI. French localization is deferred to Phase 2. The codebase preserves clean Laravel translation conventions (`lang/en/`) to facilitate fast translation injection in Phase 2.
* **Classification:** **`[CONFIRMED]`**

---

### 16. Rider Account Provisioning Without an Admin Panel
* **Context:** Without an Admin Panel in MVP, how are drivers onboarded?
* **Proposed Default for MVP:** Via a dedicated secure Artisan CLI command (`php artisan make:rider`) and database seeders executed by system operators.
* **Classification:** **`[PROPOSED]`**

---

### 17. Estimated Montreal Arrival Time for Route B
* **Context:** Route B departs Yonge Station (Toronto) at 1:15 PM. What arrival time should be displayed to passengers for Montreal?
* **Proposed Default for MVP:** **~7:15 PM Eastern Time** (approximately 6 hours travel time including rest stops and traffic allowance). Displayed with a clear disclaimer: *"Estimated arrival subject to highway traffic."*
* **Classification:** **`[PROPOSED]`**

---

### 18. Unified Login System with Role-Based Redirection
* **Context:** Should Passengers, Riders, and Operators use separate login portals or a single shared authentication page?
* **Specification:** All roles authenticate via a single shared `/login` endpoint. Post-login redirection is handled dynamically via the authenticated user's role (`passenger.dashboard`, `rider.dashboard`, `operator.dashboard`). Legacy `/rider/login` is removed. Server-side middleware strictly enforces role boundaries, rejecting manual URL tampering with `HTTP 403 Forbidden`.
* **Classification:** **`[CONFIRMED]`**

---

### 19. Mobile-First Responsive Design & iPhone Safari Priority
* **Context:** What are the priority mobile targets and layout constraints?
* **Specification:** All pages and components must be designed mobile-first (baseline 360px+). iPhone Safari is designated as a priority target browser, requiring explicit implementation guidance for dynamic viewport height (`100dvh`), safe-area insets (`env(safe-area-inset-*)`), minimum 44 × 44 CSS pixels touch targets (seat selector tiles target approximately 48 × 48 CSS pixels or larger), and minimum 16px font sizes on form inputs to eliminate iOS auto-zoom disorientation.
* **Classification:** **`[CONFIRMED]`**

---

### 20. Extremely Simple 9-Step Passenger Booking Experience
* **Context:** How simple should the passenger booking funnel be on mobile and desktop?
* **Specification:** Streamlined 9-step customer journey: 1. Open site -> 2. Log in/quick register -> 3. Find trip -> 4. View trip info -> 5. Select stops -> 6. Choose seat(s) visually -> 7. Review fare & coupon -> 8. Confirm booking -> 9. View boarding pass. Behind the scenes, the backend coordinates the 16-step booking operational lifecycle, with database mutations occurring inside an atomic transaction under pessimistic row locking. (A completion time under 90 seconds is considered a proposed future usability benchmark subject to user testing, not a confirmed requirement).
* **Classification:** **`[CONFIRMED]`**

---

### 21. Official Vehicle Logo Asset & Brand Color Palette
* **Context:** Confirmation of brand identity and visual styling.
* **Confirmed Specification:** Confirmed via client vehicle photograph and promotional posters (`docs/assets/oliver-transport-poster-en.jpg` & `docs/assets/oliver-transport-poster-fr.jpg`):
  * **Vehicle:** Commercial Honda Odyssey minivan in silver with license plate **RAJIA**.
  * **Official Logo:** "Oliver" with black/dark slate "Ol" and vibrant grass/lime green "iver" (with green dot on the 'i'), followed by "TRANSPORT" in bold uppercase sans-serif, and subtitle "MONTREAL • TORONTO • MONTREAL".
  * **Brand Color Palette:**
    * Primary Brand Green: `#22C55E` / `#00C853` (Oliver Green, matching vehicle decal and glowing badges)
    * Primary Dark: `#111827` (Tailwind Gray 900) and `#0B0F17` (Deep Obsidian / Charcoal)
    * Crisp White: `#FFFFFF` (Surface and text contrast)
    * Accent Badge Red: `#EF4444` (Used on promotional badges "First Ride" and "Toronto to Montreal")
    * Accent Warning / Gold: `#F59E0B` / `#FBBF24` (Departure time highlight)
  * **Official Contact Information:**
    * Telephone / SMS / WhatsApp: **647-655-1884**
    * Facebook Page: **Oliver Transport** (Verified checkmark badge)
* **Classification:** **`[CONFIRMED]`**

---

### 24. Admin Panel Replaces Operator Dashboard (Deferred)
* **Context:** Terminology and scheduling for administrative back-office interface.
* **Specification:** The back-office oversight interface is officially designated as **Admin Panel** (replacing the provisional term "Operator Dashboard"). Implementation is explicitly deferred to later post-launch phases ("Oita aro onek pore korbo") so all immediate effort focuses on production-readiness of Passenger and Rider experiences.
* **Classification:** **`[CONFIRMED]`**

---

### 25. Rider Cockpit In-Vehicle Mobile Ergonomics & Cabin Map
* **Context:** Driver operational experience on smartphone while standing near the van or mounted on dashboard.
* **Specification:** The Driver manifest interface is upgraded to an interactive mobile cockpit:
  * Interactive Honda Odyssey 7-seat cabin diagram with real-time occupancy status and click-to-highlight card navigation.
  * 1-tap cash collection with integrated Change Return Calculator ($65, $70, $80, $100 tendered options).
  * Station filter pills for quick station-by-station passenger focusing.
  * Direct Sunlight / High-Contrast toggle mode for outdoor car-mount visibility.
* **Classification:** **`[CONFIRMED]`**
