# Oliver Transport — Architecture & Technical Documentation

## 1. Project Overview

**Oliver Transport** is a scheduled intercity passenger shuttle service operating between **Montreal and Toronto, Canada**. The business provides daily, fixed-schedule, reserved-seat transportation connecting predefined stations in Montreal and Toronto.

* **Primary Operating Corridor:** Montreal (Station Metro Namur) ↔ Toronto (Yorkdale Mall & Yonge Station).
* **Initial Fleet:** One (1) dedicated commercial shuttle vehicle with six (6) bookable passenger seats. Driver seat is permanently excluded from booking.
* **Operating Schedule:** Fixed daily schedule, 7 days per week, 365 days per year.
* **Timezone Standard:** `America/Toronto` (Eastern Time, with automated daylight saving time handling).
* **Booking Model:** Self-service online reservations with **instant confirmation**.
* **Settlement Model:** **Cash-only** payment collected physically by the driver upon passenger boarding in MVP.
* **Operational Control:** Dedicated mobile-optimized Rider Panel for passenger manifests and cash collection logging.

---

## 2. Current Project Status

| Dimension | Status | Notes |
|---|:---:|---|
| **Documentation Baseline** | **AUDITED & FINALIZED** | Version 1.4.0 — Confirmed Client Requirements Update (Exact 3 Locations, Brand Vehicle Assets, No Cutoff/Cancel in MVP, Multi-Seat Booking, English-First). |
| **Requirements Classification** | **VERIFIED** | Every specification is strictly classified as `[CONFIRMED]`, `[PROPOSED]`, or `[FUTURE]`. All major blocking items confirmed by client. |
| **Existing Codebase State** | **VERIFIED FRESH SKELETON** | Laravel 13.39.0 on PHP 8.4.27, Tailwind CSS v4, Vite 8, Pest PHP 5.3. Zero application code or migrations modified. |
| **Implementation Readiness** | **100% READY FOR IMPLEMENTATION** | Architecture, business requirements, brand assets, route endpoints, multi-seat allocation, and pricing rules are fully confirmed. Development may proceed immediately. |

---

## 3. Authoritative Business Decisions (Final & Confirmed)

The following four foundational architectural and commercial decisions are **FINAL** and serve as the immutable single source of truth across all technical documentation:

| Decision Area | Authoritative Decision | Architectural & Business Specification |
|---|:---:|---|
| **1. Fare Model** | **`per_trip`** | **Flat rate per passenger per trip**, completely independent of the number of stops traveled. Montreal → Yorkdale, Montreal → Yonge Station, and Yorkdale → Yonge Station all incur the identical trip base fare. Per-segment and distance-based pricing are strictly excluded. Applied fare is stored as an immutable financial snapshot on the booking record using safe decimal / integer-cents arithmetic. Regular fare: **CAD $65.00**; Promotional fare: **CAD $55.00**. Multi-seat bookings multiply base fare by seat count (`base_fare * count(seats)`). |
| **2. Coupon Types** | **`both`** | **Full support for both Percentage-based discounts** (e.g., 10% off with optional dollar cap applied to total gross fare) **and Fixed-amount discounts** (e.g., CAD $10.00 off total booking, with discount capped at eligible gross fare so net total cannot be negative). Both coupon types operate seamlessly with the `per_trip` fare model. Includes server-side validation, unique codes, time bounds, active toggles, global usage caps, per-user usage limits, and minimum booking spend. Zero coupon stacking by default. *(Note: "Both" refers strictly to the two mathematical discount types, not route applicability or geographic coverage).* |
| **3. Booking Model** | **`instant`** | **Immediate booking confirmation** upon successful atomic database transaction commit. Driver, rider, or operator pre-approval workflows are strictly excluded. The booking service executes pre-transaction checks, opens an atomic database transaction that re-validates segment availability under pessimistic database locks for all requested seats before inserting records, commits, and triggers post-commit events. Failed transactions roll back 100% of database state. Booking status (`confirmed`) and payment status (`unpaid` initially) are decoupled. |
| **4. Seat Selection** | **`choose`** | **Passenger manually chooses their preferred physical seat(s)** from an interactive visual 6-seat vehicle cabin layout (S1 front passenger + S2–S6 rear cabin). Supports multi-seat reservation (1 to 6 seats) under 1 passenger account. Occupied or conflicting seats are disabled. Selected seats are visually highlighted. Seat availability is revalidated under lock during final submission. If any seat is taken concurrently, the system returns a clear error and prompts the user to choose another seat; **the system never silently auto-assigns an alternate seat**. Segment-based sequential seat reuse is supported for non-overlapping journeys. |

---

## 4. Confirmed Operational Parameters & Client Requirements (Update v1.4.0)

The following operational and commercial decisions have been **confirmed** by the client:

1. **Exact Three Predefined Locations:**
   * Station 1 (Montreal): **Station Métro Namur** (Boarding 6:30 AM on Route A; Final Drop-off on Route B).
   * Station 2 (Toronto): **Yorkdale Mall** (1st Drop-off on Route A; 1st Pickup 12:15 PM on Route B).
   * Station 3 (Toronto): **Yonge Station** (2nd Drop-off on Route A; 2nd Pickup 1:15 PM on Route B).
   * Status: **`[CONFIRMED]`**
2. **Official Vehicle & Brand Identity Assets:**
   * Vehicle: Silver commercial **Honda Odyssey** minivan (Ontario License Plate: **RAJIA**).
   * Decal / Logo: "Oliver" with dark charcoal "Ol" and vivid lime/grass green "iver" (with green dot on 'i'), bold uppercase "TRANSPORT", and subtitle "MONTREAL • TORONTO • MONTREAL".
   * Brand Colors: Deep Obsidian `#0B0F17`, Dark Slate `#111827`, Oliver Electric Green `#22C55E`, White `#FFFFFF`, Accent Red `#EF4444`, Warning Gold `#FBBF24`.
   * Public Contact: Phone/SMS/WhatsApp: **647-655-1884**, Facebook: **Oliver Transport** (Verified).
   * Marketing Assets stored in `docs/assets/oliver-transport-poster-en.jpg` and `docs/assets/oliver-transport-poster-fr.jpg`.
   * Status: **`[CONFIRMED]`**
3. **No In-App Cancellation System in MVP:**
   * Self-service passenger cancellation is strictly excluded from the web application in MVP.
   * Cancellations and inquiries are handled out-of-band via phone/SMS (`647-655-1884`) or Facebook (`Oliver Transport`). Operators can update status in the backend if needed.
   * Status: **`[CONFIRMED — EXCLUDED FROM MVP]`**
4. **No Booking Cutoff Window in MVP:**
   * No departure cutoff restriction is enforced in MVP; bookings remain open up until departure time as long as vacant seats remain.
   * Status: **`[CONFIRMED — NO CUTOFF IN MVP]`**
5. **Multi-Seat Booking Supported under 1 Account:**
   * A passenger can reserve multiple seats (1 to 6 seats, up to vehicle capacity) in a single booking transaction under 1 account without restriction.
   * Gross fare = `base_fare * count(seats)`. Net cash payable = `max(0, gross_fare - discount)`.
   * Status: **`[CONFIRMED]`**
6. **Language Launch Strategy:**
   * MVP launches with English UI. French localization is deferred to Phase 2, while codebase retains clean Laravel translation conventions (`lang/en/`).
   * Status: **`[CONFIRMED]`**

*Complete details are registered in [`decisions/ADR-004-pending-client-decisions-log.md`](./decisions/ADR-004-pending-client-decisions-log.md).*

---

## 5. Architecture Overview

Oliver Transport is architected as a **Service-Oriented Pragmatic Layered Laravel Monolith**:
* **Backend Layering:** Enforces strict separation across 6 distinct architectural components:
  1. **Routes:** URL endpoints, HTTP methods, middleware, and controller binding only. Zero business logic, zero DB queries, zero closures.
  2. **Controllers:** Ultra-thin coordinators. Receive validated Form Requests, call injected Domain Services, and return views, redirects, or JSON. Never execute business rules or transactions.
  3. **Form Requests:** Centralized request validation, input normalization, authorization, and custom error messages.
  4. **Domain Services:** Encapsulate 100% of business logic, entity coordination, pricing calculations, and transaction management (`DB::beginTransaction()`, `DB::commit()`). External side-effects dispatch strictly post-commit.
  5. **Eloquent Models:** Data modeling, relationships, casts, and scopes only. Free of fat orchestration workflows.
  6. **Database:** MySQL 8.0 InnoDB ACID transactions with pessimistic row locking (`SELECT ... FOR UPDATE`) serializing concurrent bookings.
* **Mandatory Eager Loading & N+1 Prevention:** Enforced system-wide via `Model::preventLazyLoading(!app()->isProduction())`. Controllers must explicitly preload required relationships (`with()`, `loadMissing()`) prior to view rendering. Zero database queries permitted in Blade views or loops.
* **Frontend:** Blade server-rendered views styled with **Tailwind CSS v4** (`@tailwindcss/vite`), augmented with lightweight Alpine.js / vanilla JS for interactive seat selection and dynamic coupon previews. Zero SPA client hydration delay; optimal search engine indexing.
* **Test Automation:** Comprehensive automated test suite powered by **Pest PHP 5.3**, covering isolated Domain Services, Form Requests, thin controllers, query-count benchmarks, and concurrency race conditions.

---

## 6. MVP Scope Boundaries

```
+--------------------------------------------------------------------------+
| INCLUDED IN MVP (PHASE 1)                                                |
| - Fixed 3 Stations (Metro Namur, Yorkdale Mall, Yonge Station)           |
| - Fixed 2 Daily Routes (Route A: 6:30 AM | Route B: 12:15 PM & 1:15 PM)  |
| - Single 6-Passenger Vehicle (Driver permanently excluded)               |
| - Segment-Based Seat Allocation Engine with visual seat picker           |
| - Flat Per-Trip Fare ($65 CAD regular / $55 CAD promotional)             |
| - Percentage and Fixed Promotional Coupons (Server-validated)            |
| - 16-Step Atomic Instant Booking Transaction                             |
| - Cash-Only Payment Tracking (Rider logs physical collection)            |
| - Passenger Portal: Upcoming/past bookings & digital boarding voucher    |
| - Mobile Rider Panel: Manifests ordered by stop sequence & click-to-call |
| - Public Marketing Pages: Home, About, FAQ, Contact, Terms, Privacy      |
+--------------------------------------------------------------------------+
                                    |
                                    v
+--------------------------------------------------------------------------+
| EXCLUDED FROM MVP (PHASES 2, 3, AND 4)                                   |
| - Web Admin CMS Panel (Managed via Artisan CLI / seeders in MVP)         |
| - Online Credit Card Gateways (Stripe / Moneris / PayPal)                |
| - Automated Electronic Refunds                                           |
| - Dynamic Route, Stop, or Schedule Builders                              |
| - Multi-Vehicle Fleet Dispatching                                        |
| - Live GPS Vehicle Map Tracking & Telematics                             |
| - Paid Third-Party SMS / WhatsApp Gateways (Twilio)                      |
| - Native Mobile Applications (iOS / Android)                             |
+--------------------------------------------------------------------------+
```

---

## 7. Master Document Index

| Category | File | Description | Status |
|---|---|---|:---:|
| **Overview & Scope** | [`00-project-overview.md`](./00-project-overview.md) | High-level commercial model, operational parameters, and business mission. | Audited |
| | [`01-project-scope.md`](./01-project-scope.md) | MVP inclusion boundaries, explicit exclusions, phase milestones, and timeline budget. | Audited |
| **Requirements** | [`02-business-requirements.md`](./02-business-requirements.md) | Fixed locations, operational schedules, route definitions, daily operations, and timezone rules. | Audited |
| | [`03-functional-requirements.md`](./03-functional-requirements.md) | Functional capabilities across Passenger and Rider modules. | Audited |
| | [`04-non-functional-requirements.md`](./04-non-functional-requirements.md) | Performance, concurrency, reliability, auditability, and data integrity benchmarks. | Audited |
| **Domain Architecture**| [`05-user-roles-and-permissions.md`](./05-user-roles-and-permissions.md) | Role-based authorization matrix (Guest, Passenger, Rider, System Operator). | Audited |
| | [`06-system-architecture.md`](./06-system-architecture.md) | Laravel 13 monolithic architecture, service boundaries, layered patterns, and transaction design. | Audited |
| | [`07-database-design.md`](./07-database-design.md) | Normalized relational schema (13 tables), data dictionary, indexing, and Mermaid ER diagram. | Audited |
| **Core Business Logic**| [`08-booking-workflow.md`](./08-booking-workflow.md) | **16-step atomic booking lifecycle**, instant confirmation mechanics, and state machines. | Audited |
| | [`09-seat-management.md`](./09-seat-management.md) | **Segment-based availability algorithm**, interval overlap math, cabin layout, and concurrency locks. | Audited |
| | [`10-coupon-and-pricing.md`](./10-coupon-and-pricing.md) | **Per-trip fare model** ($65 / $55 CAD), percentage & fixed coupons, and safe integer arithmetic. | Audited |
| | [`11-rider-management.md`](./11-rider-management.md) | Rider panel, stop-ordered trip manifests, cash collection logging, and privacy boundaries. | Audited |
| | [`12-payment-and-cancellation.md`](./12-payment-and-cancellation.md) | Cash-only payment lifecycle, physical collection auditing, and cancellation policies. | Audited |
| **Frontend & UX** | [`13-ui-ux-guidelines.md`](./13-ui-ux-guidelines.md) | Brand identity architecture (`[PENDING ASSET]`), unified `/login`, iPhone Safari standards, 9-step booking flow. | Audited |
| | [`14-routes-and-navigation.md`](./14-routes-and-navigation.md) | Public, Passenger, and Rider route specifications and middleware authorization mapping. | Audited |
| **Engineering Quality**| [`15-security-guidelines.md`](./15-security-guidelines.md) | Zero-client-trust, IDOR prevention, Bcrypt cost 12, rate limiters, and row locking. | Audited |
| | [`16-testing-strategy.md`](./16-testing-strategy.md) | Pest test suite, unit, feature, boundary, and concurrency race-condition test plans. | Audited |
| | [`17-deployment-guide.md`](./17-deployment-guide.md) | Production infrastructure setup, environment configurations, scheduled tasks, and operations. | Audited |
| | [`18-notification-strategy.md`](./18-notification-strategy.md) | Transactional notifications via Laravel native channels (Database, Log/Email). | Audited |
| | [`19-future-roadmap.md`](./19-future-roadmap.md) | Detailed roadmap for Phases 2, 3, and 4 (Admin Panel, Online Payments, Fleet Scaling, GPS). | Audited |
| | [`20-design-system-and-homepage.md`](./20-design-system-and-homepage.md) | Design system tokens, Blade components, vehicle branding analysis, and homepage implementation. | Implemented |
| **Architecture Records**| [`decisions/README.md`](./decisions/README.md) | Architectural Decision Records (ADR) index and summary. | Audited |
| | [`decisions/ADR-001-segment-based-seat-allocation.md`](./decisions/ADR-001-segment-based-seat-allocation.md) | ADR: Segment-Based Seat Allocation vs. Simplistic Trip Boolean. | Accepted |
| | [`decisions/ADR-002-cash-only-payment-lifecycle.md`](./decisions/ADR-002-cash-only-payment-lifecycle.md) | ADR: Cash-Only Settlement & Independent Payment Lifecycle. | Accepted |
| | [`decisions/ADR-003-modular-monolith-blade-stack.md`](./decisions/ADR-003-modular-monolith-blade-stack.md) | ADR: Pragmatic Modular Monolith with Blade & Tailwind v4. | Accepted |
| | [`decisions/ADR-004-pending-client-decisions-log.md`](./decisions/ADR-004-pending-client-decisions-log.md) | Comprehensive Registry of 21 Client Decisions & Proposed Defaults. | Audited |
| **Operational Workflows**| [`workflows/passenger-registration.md`](./workflows/passenger-registration.md) | Step-by-step customer account registration and session establishment. | Audited |
| | [`workflows/passenger-booking.md`](./workflows/passenger-booking.md) | Extremely simple 9-step passenger booking journey and 16-step backend transaction. | Audited |
| | [`workflows/seat-allocation.md`](./workflows/seat-allocation.md) | Low-level segment availability query execution and row locking. | Audited |
| | [`workflows/coupon-validation.md`](./workflows/coupon-validation.md) | Two-stage coupon validation, decimal limits, and usage tracking. | Audited |
| | [`workflows/cash-payment.md`](./workflows/cash-payment.md) | In-person cash collection, modal confirmation, and audit logging. | Audited |
| | [`workflows/rider-trip-management.md`](./workflows/rider-trip-management.md) | Daily driver operational progression across Route A and Route B. | Audited |
| **Changelog** | [`changelog/CHANGELOG.md`](./changelog/CHANGELOG.md) | Version history of specifications, audits, and architectural updates. | Audited |

---

## 8. Implementation Readiness Checklist

Prior to beginning development, the engineering team must verify this readiness checklist:

- [x] **Technical Stack Verified:** Host environment runs PHP 8.4.27, Laravel 13.39.0, Vite 8, Tailwind CSS v4, MySQL 8, Pest PHP 5.3.
- [x] **Four Authoritative Decisions Reconciled:** `per_trip` fare model, `both` coupon types, `instant` booking model, and `choose` seat selection enforced across all documentation.
- [x] **Unified Authentication System Documented:** Single shared `/login` endpoint with role-based post-login redirection (`passenger.dashboard`, `rider.dashboard`, `operator.dashboard`) and server-side URL tamper defense.
- [x] **Mobile-First & iPhone Safari Guidelines Established:** Dynamic viewport height (`100dvh`), safe-area insets (`env(safe-area-inset-*)`), minimum 44 × 44 CSS pixels touch targets (seat selector tiles target approximately 48 × 48 CSS pixels or larger), and 16px minimum font size on inputs specified.
- [x] **Extremely Simple 9-Step Booking Journey Defined:** Frictionless customer flow mapped against the 16-step booking operational lifecycle and atomic database transaction.
- [x] **16-Step Booking Operational Lifecycle Documented:** Consistent operational sequence across Stage A (pre-transaction checks), Stage B (atomic database transaction), and Stage C (post-commit actions) verified in architecture, booking workflow, and operational workflow documents.
- [x] **Segment-Based Seat Allocation Specified:** Mathematical interval overlap theorem $(B_A < D_B) \land (B_B < D_A)$ defined with pessimistic row locking on physical seat records.
- [x] **Database Schema Audited:** 13 normalized tables defined with complete data dictionary, relational foreign keys, indexes, and Mermaid ER diagram.
- [x] **Requirements Strictly Classified:** All requirements classified into `[CONFIRMED]`, `[PROPOSED]`, `[PENDING]`, or `[FUTURE]`.
- [x] **Architecture & Core Technical Direction:** Fully documented across 33 technical specifications.
- [x] **Four Foundational Business Decisions:** Confirmed (`per_trip` fare model, `both` coupon types, `instant` booking, `choose` seat selection).
- [x] **Authentication & UX Requirements:** Confirmed (unified `/login` with role redirection, mobile-first iPhone Safari guidelines, 9-step booking journey).
- [x] **Service-Oriented Laravel Architecture Enforced:** 6-component architecture (Routes, Controllers, Form Requests, Domain Services, Eloquent Models, Database) fully documented across all modules.
- [x] **Thin Controllers & Form Request Validation:** Controllers restricted to HTTP coordination; business logic quarantined in 10 Domain Services; input sanitization centralized in 8 Form Requests.
- [x] **Service-Owned Database Transactions:** `BookingService`, `PaymentService`, and `CouponService` own ACID transactions; external events fire strictly post-commit.
- [x] **Mandatory Eager Loading & N+1 Query Elimination:** Enforced via `Model::preventLazyLoading(!app()->isProduction())`, relationship preloading protocols, and query-count benchmark tests.
- [x] **Official Brand Asset Delivered & Confirmed:** Brand palette and vehicle decals extracted from official photos (`docs/assets/oliver-transport-poster-en.jpg` & `docs/assets/oliver-transport-poster-fr.jpg`). Honda Odyssey (Plate: "RAJIA"), Oliver Green (`#22C55E`), Dark Charcoal (`#111827`), phone `647-655-1884`.
- [x] **All Operational Policies Reconciled:** Exact 3 locations (Métro Namur, Yorkdale Mall, Yonge Station), Route B drop-off (Métro Namur), no cutoff gate, no in-app cancellation (out-of-band support only), multi-seat booking (1 to 6 seats), and English-first UI confirmed.
- [x] **Implementation Readiness Complete:** Migrations, seeders, core models, service layer, Form Requests, controllers, Blade views, and Pest test suite are 100% unlocked for development.
- [x] **Internal Links & Diagrams Verified:** All markdown cross-links resolve to valid relative paths; Mermaid diagrams render valid syntax.
- [x] **Codebase Preservation Confirmed:** Zero application code, migrations, models, controllers, routes, dependencies, or `.env` files modified during documentation tasks.
