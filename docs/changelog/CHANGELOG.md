# Changelog — Oliver Transport Technical Documentation

All notable architectural and specification changes to the Oliver Transport technical documentation suite are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.4.0] — 2026-11-03

### Confirmed Client Requirements & Brand Asset Integration

#### Brand Identity Assets Ingested & Confirmed
* Ingested and archived official client promotional posters and vehicle photographs (`docs/assets/oliver-transport-poster-en.jpg` and `docs/assets/oliver-transport-poster-fr.jpg`).
* Confirmed commercial vehicle: Silver Honda Odyssey minivan, Ontario license plate **RAJIA**.
* Confirmed official logo mark: "Oliver" with dark charcoal "Ol" and vivid lime/grass green "iver" (with green dot on 'i'), bold uppercase "TRANSPORT", and subtitle "MONTREAL • TORONTO • MONTREAL".
* Confirmed brand color palette: Deep Obsidian (`#0B0F17`), Dark Slate (`#111827`), Oliver Electric Green (`#22C55E`), Crisp White (`#FFFFFF`), Badge Red (`#EF4444`), Gold Yellow (`#FBBF24`).
* Confirmed official public channels: Phone/SMS/WhatsApp **647-655-1884**, Facebook **Oliver Transport** (Verified).

#### Exact Three Predefined Locations Confirmed
* Formally confirmed system-wide stations:
  1. **Station Métro Namur** (Montreal, QC) — Origin for Route A (6:30 AM departure); final destination drop-off for Route B.
  2. **Yorkdale Mall** (Toronto, ON) — 1st drop-off for Route A; 1st pickup for Route B (12:15 PM).
  3. **Yonge Station** (Toronto, ON) — 2nd drop-off for Route A; 2nd pickup for Route B (1:15 PM).

#### Multi-Seat Booking (1 to 6 Seats per Account) Enforced
* Enabled multi-seat reservations under a single user account without artificial limits up to cabin capacity (1 to 6 passenger seats).
* Updated relational schema: added `bookings.seat_count` (`TINYINT UNSIGNED`), confirmed 1:N relationship with `booking_seats`.
* Updated fare calculation: `gross_base_fare = base_fare * seat_count`; `final_fare = max(0, gross_base_fare - discount)`.
* Updated concurrency locking in `BookingService`: pessimistic batch row lock (`SELECT * FROM vehicle_seats WHERE id IN (...) FOR UPDATE`). If any requested seat is occupied on an overlapping segment, the entire transaction rolls back.

#### No In-App Cancellation or Booking Cutoff in MVP
* Confirmed exclusion of in-app self-service booking cancellations in MVP. All bookings are instant and confirmed upon commit. Customer cancellations/rescheduling are handled out-of-band via phone/SMS (`647-655-1884`) or Facebook.
* Confirmed exclusion of departure booking cutoff gate in MVP; passengers may book seats up until scheduled departure time as long as vacant seats remain.

#### Language Launch Strategy
* Confirmed English-first UI for MVP launch. French localization is deferred to Phase 2 while preserving clean Laravel translation keys (`lang/en/`).

---

## [1.3.0] — 2026-11-03

### Laravel Architecture Standards Update (Service-Oriented Architecture & N+1 Prevention)

#### Required 6-Layer Application Architecture Codified
* Formally codified and enforced the 6-layer Laravel architecture across all modules:
  1. **Routes:** URL endpoints, HTTP methods, controller references, and middleware mapping only. Web routes, Blade-first; strictly zero business logic, database queries, or inline closures.
  2. **Controllers:** Ultra-thin coordinators. Receive validated Form Request objects, invoke injected Domain Services, and return views, redirects, or JSON. Strictly zero business logic, direct DB queries, or transaction management.
  3. **Form Requests:** Dedicated validation classes centralizing input sanitization, type coercion, request-level authorization, and custom error messages.
  4. **Domain Services:** Encapsulate 100% of business logic, domain algorithms, pricing/coupon calculations, concurrency locking, and database transactions.
  5. **Eloquent Models:** Data modeling, relationships, attribute casting, accessors/mutators, and query scopes only. Free of fat multi-step orchestration workflows.
  6. **Database:** MySQL 8.0 InnoDB ACID transactions with pessimistic row locking (`SELECT ... FOR UPDATE`) serializing concurrent booking operations.

#### Domain Service & Form Request Catalogs Defined
* Documented the comprehensive catalog of 10 dedicated Domain Services:
  * `AuthenticationService`, `PassengerService`, `TripService`, `BookingService`, `SeatAvailabilityService`, `PricingService`, `CouponService`, `PaymentService`, `RiderService`, `NotificationService`.
* Documented the catalog of 8 dedicated Form Request classes:
  * `LoginRequest`, `RegisterPassengerRequest`, `SearchTripRequest`, `CreateBookingRequest`, `CancelBookingRequest`, `ApplyCouponRequest`, `CollectCashPaymentRequest`, `AssignRiderRequest`.

#### Mandatory Eager Loading & N+1 Query Elimination Enforced
* Introduced `NFR-13` (Mandatory Eager Loading & N+1 Query Elimination) and `NFR-14` (Layered Service Architecture & Thin Controllers).
* Added explicit relationship preloading requirements across all primary query paths in `07-database-design.md`, `06-system-architecture.md`, `11-rider-management.md`, and `12-payment-and-cancellation.md`.
* Codified development safeguard in `AppServiceProvider`: `Model::preventLazyLoading(!app()->isProduction())`.
* Prohibited direct database queries inside Blade views or loops; mandated bounded query counts ($\le 3$ to $4$ queries per view).

#### Service-Owned Database Transactions
* Formally designated `BookingService`, `PaymentService`, and `CouponService` as transaction owners (`DB::beginTransaction()`, `commit()`, `rollBack()`).
* Enforced that external side-effects (domain events, email/SMS dispatch via `NotificationService`) execute strictly post-commit.

#### Updated Route & Navigation Architecture
* Reconciled all route tables in `14-routes-and-navigation.md` to specify Route Names, Target Controllers, Form Requests, and Injected Services.
* Added rules `BR-NAV-04` (URL Mapping Only) and `BR-NAV-05` (Thin Controller Binding).

#### Preservation of All Confirmed Business Decisions
* Preserved all 4 authoritative decisions: `per_trip` fare model, `both` coupon types, `instant` booking, `choose` seat selection.
* Preserved unified `/login` flow, mobile-first iPhone Safari guidelines, and 9-step booking journey.

---

## [1.2.1] — 2026-11-03

### Technical Accuracy, Transaction Boundaries & Readiness Review

#### Mobile Touch Target Dimensions Corrected
* Corrected malformed touch measurements across all documentation to valid CSS dimensions:
  * General interactive controls: minimum 44 × 44 CSS pixels.
  * Seat selection tiles: target approximately 48 × 48 CSS pixels or larger.
* Eliminated unescaped math expressions and unformatted strings (`4444px`, `4848px`).

#### Removed Unsupported 90-Second Booking Guarantee
* Clarified that the confirmed requirement is for the booking flow to be simple, intuitive, and require minimal unnecessary steps `[CONFIRMED]`.
* Reclassified the "under 90 seconds" target as a proposed future UX usability benchmark subject to user testing and sign-off `[PROPOSED]`, removing any implication of a strict confirmed SLA.

#### Corrected Atomic Transaction Boundaries Across 3 Stages
* Clearly delineated the 16-step booking operational lifecycle into three distinct architectural stages:
  * **Stage A: Pre-Transaction Checks (Outside DB Transaction):** Session authentication, role authorization, request payload format validation, and idempotency token verification.
  * **Stage B: Database Transaction (`DB::beginTransaction()` to `DB::commit()`):** Trip existence and schedule validation (cutoff conditional on approval), stops and forward sequence validation, seat vehicle association, pessimistic row lock acquisition on `vehicle_seats` (`SELECT ... FOR UPDATE`), segment availability re-check under lock, per-trip fare resolution, coupon row locking and validation, final fare calculation in integer cents, booking creation (`OT-YYYY-XXXX`), seat allocation insertion, cash payment creation (`status = 'unpaid'`), coupon usage logging, and database commit.
  * **Stage C: Post-Commit Actions (Outside DB Transaction):** Domain event dispatch (`BookingConfirmed`), notification triggering, and HTTP response delivery / boarding pass display.
* Updated architectural text and sequence diagrams in `docs/08-booking-workflow.md`, `docs/06-system-architecture.md`, `docs/13-ui-ux-guidelines.md`, and `docs/workflows/passenger-booking.md`.

#### Preserved Pending Booking Cutoff Status
* Ensured departure cutoff validation is explicitly labeled as conditional on client approval of a cutoff policy.
* Reclassified Booking Cutoff Threshold (PD-11) as `[PENDING]` in the decisions log, removing any enforcement of an unapproved default rule.

#### Corrected Horizontal Overflow Guidance
* Removed instructions advocating global `overflow-x: hidden` on body or top-level containers.
* Specified responsive layout best practices (flexible grids, relative sizing, proper flex wrapping) to prevent unintended horizontal overflow.
* Clarified that intentional horizontal scrolling is reserved for components that genuinely require it (e.g., wide passenger manifests on narrow screens) with momentum scrolling (`-webkit-overflow-scrolling: touch`), without clipping essential content or interactive controls.

#### Refined iPhone Safari Implementation Guidance
* Clarified that iPhone Safari engineering standards (viewport `100dvh`, safe-area insets, 16px input font, touch targets) represent implementation guidance and testing acceptance criteria for Sprint QA, not claims that the fresh Laravel skeleton has already passed Safari testing.

#### Accurate Implementation Readiness Classification
* Replaced blanket readiness claims with a nuanced, architecturally honest classification:
  * Architecture & Core Technical Direction: Documented across 33 technical specifications.
  * Four Foundational Business Decisions: Confirmed (`per_trip`, `both` coupons, `instant` booking, `choose` seat).
  * Authentication & UX Requirements: Confirmed (unified `/login`, mobile-first guidelines, 9-step booking journey).
  * Brand Palette & Vector Logo: Blocked pending delivery of official vehicle photograph (`[PENDING ASSET]`).
  * Remaining Business Policies: Pending client approval (Route B Montreal drop-off, promotional fare expiry, cancellation rights, cutoff threshold).
  * Foundational Non-Dependent Development: May proceed after human review (migrations, core models, service interfaces, auth scaffolding).
  * Dependent Features Guard: Features strictly dependent on unresolved policies must not be finalized without explicit client approval.

---

## [1.2.0] — 2026-11-03

### UX, Unified Authentication, iPhone Safari & Branding Release

#### Unified Login System with Role-Based Redirection [CONFIRMED]
* **Single Shared Authentication Interface:**
  * Reconciled all documentation to mandate a single shared login page (`GET /login`).
  * Permanently eliminated legacy separate rider login routes (`/rider/login`).
  * Implemented deterministic role-based post-login redirection via `AuthenticatedSessionController` to `passenger.dashboard`, `rider.dashboard`, or `operator.dashboard`.
* **Server-Side Authorization & Anti-Tampering:**
  * Enforced server-side role sandboxing via `RoleMiddleware`. If an authenticated Passenger attempts to access `/rider/dashboard`, or a Rider attempts to access passenger booking endpoints, the server returns `HTTP 403 Forbidden`.
  * Preserved intended destination routing (`redirect()->intended()`) only when the destination matches the authorized role.

#### Mobile-First Responsive Design & iPhone Safari Priority [CONFIRMED]
* **iPhone Safari Engineering Standards:**
  * Mandated dynamic viewport height (`100dvh` / `min-h-[100dvh]`) to eliminate Safari bottom address bar clipping and page jumping.
  * Required safe-area insets (`env(safe-area-inset-top)`, `env(safe-area-inset-bottom)`, `env(safe-area-inset-left)`, `env(safe-area-inset-right)`) for notch, Dynamic Island, and home indicator bar compatibility.
  * Mandated minimum 44 × 44 CSS pixels touch targets across all interactive buttons, links, and cabin seat selection tiles (targeting approximately 48 × 48 CSS pixels or larger for seats).
  * Enforced minimum `16px` font size (`text-base`) on all form inputs (`<input>`, `<select>`, `<textarea>`) to prevent iOS Safari auto-zoom on focus.
  * Specified proper mobile keyboard triggers (`type="tel"`, `type="email"`, `inputmode="numeric"`).
  * Emphasized horizontal overflow prevention through responsive layout design and touch momentum scrolling (`-webkit-overflow-scrolling: touch`) where scrolling is genuinely required.
  * Added real-device iPhone Safari physical/simulator testing to Sprint acceptance gates.

#### Extremely Simple 9-Step Passenger Booking Experience [CONFIRMED]
* **Streamlined Customer Journey:**
  * Replaced previous 15-step booking descriptions with a clean, intuitive **9-Step Passenger Journey**:
    1. Open site -> 2. Log in / quick register -> 3. Find trip -> 4. View trip info -> 5. Select stops -> 6. Choose seat visually -> 7. Review fare & coupon -> 8. Confirm booking -> 9. View boarding pass.
* **Frontend Simplicity vs. Backend Robustness Mapping:**
  * Documented explicit contrast mapping between the frictionless 9-step customer frontend UX and the robust 16-step backend atomic database transaction under pessimistic row locking.

#### Official Logo & Brand Color Theme Architecture [CONFIRMED — ASSET-DEPENDENT]
* **Asset-Dependent Status Codified:**
  * Documented client confirmation that the official company logo is on the vehicle image.
  * Marked exact brand hex colors and vector logo file assets as **`[CONFIRMED — ASSET-DEPENDENT]`** / **`[PENDING ASSET]`** because the vehicle photograph is not yet committed to the repository.
  * Established strict architectural rule prohibiting developers or designers from inventing, guessing, or creating mock branding colors or replacement logos.
  * Defined complete Tailwind CSS v4 design token architecture in `resources/css/app.css` using placeholder custom properties ready for instant color injection upon image delivery.
  * Updated Implementation Readiness Checklist to honestly reflect that while backend and architecture are 100% ready for Sprint 0, frontend visual styling is asset-dependent.

---

## [1.1.0] — 2026-11-03

### Requirements Audit, Reconciliation & Finalization Release

#### Reconciled & Authoritative Decisions Enforced
* **Strict `per_trip` Fare Model Enforced:**
  * Reconciled pricing across all documents to mandate a flat fare per passenger per trip ($65.00 regular / $55.00 promotional CAD).
  * Explicitly confirmed that intermediate travel (e.g., Yorkdale Mall → Yonge Station) incurs the full per-trip base fare. Distance-based or per-segment pricing is strictly prohibited.
  * Preserved promotional fare expiration date as `[PENDING]` client confirmation, configured via `config/pricing.php`.
* **Both Coupon Discount Types Confirmed:**
  * Enforced support for both percentage-based (with optional dollar caps) and fixed-amount discounts (capped at the eligible fare so net total cannot be negative).
  * Clarified that "both" refers strictly to mathematical discount mechanisms, working uniformly under the `per_trip` fare model without stacking by default.
* **Instant Booking Model Solidified:**
  * Prohibited any pending-approval queues; confirmed bookings are immediately committed upon atomic database transaction execution.
  * Decoupled booking reservation status (`confirmed`) from physical cash settlement status (`unpaid` initially).
* **Manual Seat Selection (`choose`) Reinforced:**
  * Enforced visual manual passenger seat choice from the 6-seat vehicle cabin layout.
  * Mandated that if a seat is claimed concurrently, the system aborts with `HTTP 409 Conflict`, displays an error toast, and prompts the user to select another seat; **the system never silently auto-assigns an alternate seat**.

#### Architecture & Workflow Enhancements
* **Standardized 16-Step Atomic Booking Lifecycle:**
  * Reconciled `docs/08-booking-workflow.md`, `docs/06-system-architecture.md`, and `docs/workflows/passenger-booking.md` to define the unified 16-step transaction sequence.
  * Formally documented exclusive pessimistic row locking on `vehicle_seats` (`SELECT ... FOR UPDATE`) in Step 6, executed prior to re-verifying segment vacancy (Step 7).
* **Booking Idempotency & Reference Generation:**
  * Specified client-generated UUID idempotency keys to prevent duplicate reservations caused by double-clicking or network retries.
  * Specified reference generation algorithm: `OT-YYYY-XXXX` with collision-retry loop, excluding ambiguous characters (`0`, `O`, `1`, `I`).
* **Database Schema Audit & Cancellation Ledger:**
  * Added `cancelled_at` and `cancelled_by` audit columns to the `bookings` table schema in `docs/07-database-design.md`.
  * Verified all foreign key cascade and restriction rules across all 13 tables.
* **Driver Assignment & Operational Workflows:**
  * Specified operator CLI command `php artisan trip:assign-rider` in `docs/11-rider-management.md`.
* **Audit of Assumptions & Classifications:**
  * Audited every requirement across all 33 documents, ensuring proposed technical defaults are strictly labeled `[PROPOSED]` or `[PENDING]` and never erroneously labeled `[CONFIRMED]`.
  * Reconciled master `docs/README.md` with executive project status, authoritative decisions summary, and an implementation readiness checklist.

---

## [1.0.0] — 2026-11-03

### Initial Architecture & Technical Documentation Baseline Release

#### Added
* **Project Overview & Commercial Scope (`docs/00-project-overview.md`, `docs/01-project-scope.md`):**
  * Formally defined scheduled intercity shuttle model between Montreal and Toronto.
  * Formulated MVP boundaries: single 6-passenger van, 3 fixed locations, 2 daily routes, cash-only settlement, instant booking.
  * Defined 7-day implementation roadmap and phase boundaries (Phases 1 through 4).
* **Business & Functional Requirements (`docs/02-business-requirements.md`, `docs/03-functional-requirements.md`, `docs/04-non-functional-requirements.md`):
  * Established 3 physical hubs: Metro Namur (Montreal), Yorkdale Mall (Toronto), Yonge Station (Toronto).
  * Documented daily operational timetable: Route A (06:30 AM departure) and Route B (12:15 PM & 1:15 PM pickups).
  * Enforced `America/Toronto` Eastern Timezone with automated daylight saving time handling.
  * Formulated non-functional criteria: sub-350ms booking transaction latency, sub-150ms availability checks, zero double-booking concurrency guarantee.
* **Roles & Permissions (`docs/05-user-roles-and-permissions.md`):**
  * Specified role hierarchy: Guest, Passenger, Rider, and System Operator.
  * Designed IDOR prevention and policy sandboxing between passenger and rider portals.
* **System & Database Architecture (`docs/06-system-architecture.md`, `docs/07-database-design.md`):**
  * Designed Laravel 13 modular monolithic architecture with thin controllers and isolated domain services.
  * Authored complete normalized 3NF database schema covering 13 core entities with full Mermaid ER diagram.
  * Specified financial historical price snapshots (`base_fare`, `discount_amount`, `final_fare`, `currency`).
* **Booking & Seat Management (`docs/08-booking-workflow.md`, `docs/09-seat-management.md`):**
  * Engineered **Segment-Based Seat Availability Engine** using mathematical interval overlap theorem:
    $$\text{Overlap} \iff (B_A < D_B) \land (B_B < D_A)$$
  * Prohibited simplistic trip-wide `is_booked` flags; enabled legitimate non-overlapping seat reuse.
  * Designed visual 6-seat vehicle cabin layout (S1 front passenger + S2–S6 rear rows).
* **Pricing & Coupons (`docs/10-coupon-and-pricing.md`):**
  * Configured $65.00 regular and $55.00 introductory CAD fares per passenger per trip.
  * Specified percentage (e.g. 10%) and fixed-dollar (e.g. $10 CAD) coupon engine with server-side validation.
  * Designed decimal-safe integer cents monetary arithmetic.
* **Rider Operations & Cash Settlement (`docs/11-rider-management.md`, `docs/12-payment-and-cancellation.md`):**
  * Designed mobile-optimized Rider Panel with stop-by-stop passenger manifests.
  * Specified in-person cash collection logging and decoupled booking status (`confirmed`) from payment status (`unpaid` / `paid`).
  * Documented pending cancellation policies and excluded automated electronic refunds.
* **UI/UX & Routing (`docs/13-ui-ux-guidelines.md`, `docs/14-routes-and-navigation.md`):**
  * Extracted brand aesthetic from promotional collateral: Dark green `#08140E`, neon green `#00FF66`, yellow `#FACC15`, red `#EF4444`.
  * Documented complete RESTful URL routing catalog for Public, Passenger, and Rider domains.
  * Structured bilingual English/French interface architecture.
* **Security, Testing & Infrastructure (`docs/15-security-guidelines.md`, `docs/16-testing-strategy.md`, `docs/17-deployment-guide.md`, `docs/18-notification-strategy.md`, `docs/19-future-roadmap.md`):**
  * Defined zero-client-trust security rules, Bcrypt cost 12 hashing, database sessions, and rate limiters.
  * Formulated Pest PHP 5.3 automated testing suite covering unit, feature, and race-condition tests.
  * Specified production Nginx, PHP-FPM 8.4, cron scheduler, and Supervisor queue worker configurations.
  * Outlined strategic post-MVP evolution across Phases 2, 3, and 4.
* **Architectural Decisions & Workflows (`docs/decisions/`, `docs/workflows/`):**
  * Authored ADR-001 (Segment-Based Seat Allocation), ADR-002 (Cash Settlement Lifecycle), ADR-003 (Modular Monolith Stack).
  * Created ADR-004: Comprehensive Pending Client Decisions Log detailing all 17 open questions with recommended defaults.
  * Formulated 6 comprehensive step-by-step operational workflow documents with Mermaid sequence diagrams.
