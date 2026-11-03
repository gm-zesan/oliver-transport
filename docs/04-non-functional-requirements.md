# 04 — Non-Functional Requirements

## 1. Document Purpose
This document defines the quality attributes, architectural benchmarks, performance targets, security standards, and operational constraints required to ensure the **Oliver Transport** platform is robust, concurrent-safe, maintainable, and production-grade.

---

## 2. Scope
* **In Scope:** System performance criteria, transactional concurrency safety, relational database integrity, security posture, accessibility, and code quality standards for the MVP deployment.
* **Out of Scope:** Multi-region geographically distributed databases, enterprise PCI-DSS audits (no credit card data stored), and automated Kubernetes cluster auto-scaling.

---

## 3. Relevant Requirements

| ID | Non-Functional Dimension | Specification Benchmark | Classification |
|---|---|---|---|
| NFR-01 | **Concurrency & Double-Booking Prevention** | Zero duplicate seat bookings under simulated concurrent requests | **`[CONFIRMED]`** |
| NFR-02 | **Transactional Atomicity (ACID)** | 100% rollback of state on transaction failure (seat, booking, coupon, payment) | **`[CONFIRMED]`** |
| NFR-03 | **Monetary Precision** | Exact 2-decimal / integer-cents arithmetic; floating-point math strictly prohibited | **`[CONFIRMED]`** |
| NFR-04 | **Timezone Correctness** | Operational schedule accuracy across Eastern Time (`America/Toronto`) DST shifts | **`[CONFIRMED]`** |
| NFR-05 | **Response Latency (Read Operations)** | Seat availability queries resolve in $\le 150\text{ ms}$; page loads $\le 800\text{ ms}$ | **`[PROPOSED]`** |
| NFR-06 | **Response Latency (Write Operations)** | 16-step booking transaction completes and responds in $\le 350\text{ ms}$ | **`[PROPOSED]`** |
| NFR-07 | **Submission Idempotency** | Prevents double bookings from double clicks or network retry submissions | **`[CONFIRMED]`** |
| NFR-08 | **Mobile-First Design & iPhone Safari Priority** | Mobile-first baseline (360px+); iPhone Safari implementation guidance (100dvh, safe areas, 44 × 44 CSS pixels, 16px inputs) | **`[CONFIRMED]`** |
| NFR-09 | **Security & OWASP Top 10** | Strict protection against CSRF, SQL Injection, XSS, and IDOR vulnerabilities | **`[CONFIRMED]`** |
| NFR-10 | **Test Automation Coverage** | Automated test suite covering critical domain paths (Pest framework) | **`[CONFIRMED]`** |
| NFR-11 | **Data Privacy & Protection** | Passenger contact details visible only to authorized riders on assigned trips | **`[CONFIRMED]`** |
| NFR-12 | **Unified Authentication & Role Redirection** | Single shared `/login` endpoint with dynamic role dispatch and server-side barrier | **`[CONFIRMED]`** |
| NFR-13 | **Mandatory Eager Loading & N+1 Prevention** | Relationships preloaded before rendering views; zero DB queries in Blade; `Model::preventLazyLoading()` enabled in dev/test | **`[CONFIRMED]`** |
| NFR-14 | **Layered Service Architecture & Thin Controllers** | Strict separation: Routes → Requests → Thin Controllers → Services → Models; transactions owned exclusively by Services | **`[CONFIRMED]`** |

---

## 4. Performance & Scalability Benchmarks

### 4.1 Response Time Budgets (95th Percentile)
Under a baseline load of up to 50 concurrent active users browsing and booking:
* **Public Informational Pages:** $\le 300\text{ ms}$
* **Real-Time Seat Availability AJAX Endpoint:** $\le 150\text{ ms}$
* **Coupon Validation AJAX Endpoint:** $\le 100\text{ ms}$
* **16-Step Booking Creation Transaction Execution:** $\le 350\text{ ms}$
* **Rider Manifest Load:** $\le 200\text{ ms}$

### 4.2 Database Optimization
* All foreign keys must have corresponding B-Tree indexes.
* Composite index on `route_stops(route_id, stop_sequence)` for instant sequence lookups.
* Composite index on `booking_seats(trip_id, vehicle_seat_id, boarding_sequence, dropoff_sequence)` to optimize interval overlap collision queries.
* Query execution plans must demonstrate zero full-table scans during booking and availability checks.

### 4.3 Mandatory Eager Loading & N+1 Query Elimination
* **Relationship Preloading (`with()`, `load()`, `loadMissing()`):** All relational associations required by Blade templates or response builders must be explicitly eager loaded in the service or controller query.
* **Prohibition of In-Loop & In-View Queries:** Executing database queries inside loops or Blade views is strictly forbidden.
* **Specific Query Requirements:**
  * **Trip Listings:** Preload `route.stops.location`, `assignedVehicle`, and `scheduleTemplate`.
  * **Booking History:** Preload `trip.route`, `bookingSeats.vehicleSeat`, and `payment`.
  * **Rider Manifests:** Preload `user:id,name,phone`, `bookingSeats.vehicleSeat:id,seat_number`, and `payment`.
  * **Operator Dashboards:** Use `withCount()` and SQL aggregations (`withSum()`, `sum()`) instead of loading full model collections.
* **Development Safeguard:** `Model::preventLazyLoading(! app()->isProduction())` must be active in non-production environments to instantly catch and fail unoptimized queries.
* **Column Selection & Pagination:** Restrict fetched columns (`select(['id', ...])`) for large collections and paginate public/passenger listings.

---

## 5. Concurrency Control & Data Integrity

### 5.1 Race Condition Protection
When multiple passengers attempt to reserve the same seat simultaneously:
1. In Step 6 of the booking transaction, the system enforces **pessimistic row locking** (`SELECT * FROM vehicle_seats WHERE id = ? FOR UPDATE`).
2. The segment availability check (Step 7) is executed *after* the lock is acquired within the active transaction.
3. If an overlap conflict is detected, the transaction terminates cleanly with an `HTTP 409 Conflict` response, informing the second user that the seat was claimed moments prior and prompting them to choose another seat.
4. Under no circumstances may two overlapping bookings exist in the database for the same physical seat on the same dated trip.

```mermaid
sequenceDiagram
    autonumber
    actor UserA as Passenger A
    actor UserB as Passenger B
    participant App as Laravel Application
    participant DB as MySQL Database

    UserA->>App: Book Seat S1 (Montreal -> Toronto)
    UserB->>App: Book Seat S1 (Montreal -> Toronto)
    App->>DB: [Tx A] BEGIN & SELECT Seat S1 FOR UPDATE
    activate DB
    Note over DB: Lock granted to Transaction A
    App->>DB: [Tx B] BEGIN & SELECT Seat S1 FOR UPDATE
    Note over DB: Transaction B blocks waiting for lock
    App->>DB: [Tx A] Verify Overlap: None -> Insert Booking -> COMMIT
    deactivate DB
    App-->>UserA: 201 Created (Booking Confirmed)
    activate DB
    Note over DB: Lock released to Transaction B
    App->>DB: [Tx B] Verify Overlap: Conflict with User A! -> ROLLBACK
    deactivate DB
    App-->>UserB: 409 Conflict ("Seat was just booked; please pick another seat")
```

### 5.2 Financial Precision
* All monetary values (fares, discounts, collected amounts) must be stored in the database as `DECIMAL(10, 2)` (never `FLOAT` or `DOUBLE`).
* Application calculations must utilize integer cents (`int`) or fixed-point operations to prevent floating-point rounding errors.

---

## 6. Security & Compliance Standards

### 6.1 Authentication & Session Integrity
* **Password Hashing:** Passwords hashed using Bcrypt with a work factor of 12 (configured via `BCRYPT_ROUNDS=12` in `.env`).
* **Session Security:** Cookie attributes must enforce `HttpOnly`, `SameSite=Lax`, and `Secure` (over HTTPS).
* **Session Storage:** Database-backed session store (`SESSION_DRIVER=database`) allowing instant invalidation of compromised sessions.

### 6.2 Authorization & Access Control
* **Insecure Direct Object Reference (IDOR) Prevention:**
  * Passenger can only access bookings where `booking.user_id === auth()->id()`.
  * Rider can only access trips and manifests explicitly matching `trip.rider_id === auth()->id()`.
  * Enforced via Laravel Authorization Policies (`BookingPolicy`, `TripPolicy`).

### 6.3 Input Validation & Sanitization
* All user inputs must be strongly validated via dedicated Laravel `FormRequest` classes before reaching controllers.
* Output escaping handled automatically by Blade's `{{ ... }}` syntax to prevent Cross-Site Scripting (XSS).
* Zero raw SQL queries; all database interactions utilize Eloquent ORM or parameterized query builders to prevent SQL Injection.

---

## 7. Usability, Accessibility & Cross-Device Compatibility

### 7.1 Mobile-First Architecture & iPhone Safari Compatibility
* **Mobile-First Paradigm:** Every component is designed and styled for mobile viewports (minimum 360px) first, scaling gracefully to desktop via Tailwind CSS v4.
* **iPhone Safari Standards:**
  * **Dynamic Viewport Height:** Uses `100dvh` (`min-h-[100dvh]`) with `100vh` fallback to eliminate Safari toolbar clipping.
  * **Safe-Area Insets:** Incorporates `env(safe-area-inset-*)` on sticky headers, bottom navigation, and action buttons.
  * **Touch Target Sizing:** All general interactive controls must have a minimum footprint of 44 × 44 CSS pixels; seat selector tiles target approximately 48 × 48 CSS pixels or larger.
  * **Input Auto-Zoom Prevention:** Form inputs (`<input>`, `<select>`, `<textarea>`) must enforce a minimum font size of `16px` (`text-base`) to prevent iOS Safari auto-zoom.
  * **Input Type & Keyboards:** Explicit `type="tel"`, `type="email"`, and `inputmode="numeric"` configured to invoke native mobile keyboards.
  * **Horizontal Overflow & Momentum Scrolling:** Prevent unintended horizontal overflow through flexible responsive layouts; avoid applying global `overflow-x: hidden` to the body or main containers as a catch-all fix. Allow intentional horizontal scrolling only for components that genuinely require it (e.g., wide data tables) with `-webkit-overflow-scrolling: touch`.

### 7.2 Accessibility (WCAG 2.1 Level AA)
* Visual seat status must not rely exclusively on color:
  * Available: Neutral slate border + text "Available"
  * Selected: Electric Green (`#00FF66`) + checkmark icon
  * Unavailable: Dark disabled background + "Reserved" label + strikethrough icon
* ARIA attributes (`aria-selected`, `aria-disabled`) applied to visual seating elements.

---

## 8. Maintainability, Layered Architecture & Code Quality

* **PHP Standards:** Adherence to PSR-12 coding style, enforced via Laravel Pint (`./vendor/bin/pint --test`).
* **Layered Architecture Boundaries:** Strict separation of concerns:
  * **Routes:** URL mapping only; zero closures, zero business logic.
  * **Controllers:** Thin coordinators only; receive Form Requests, call services, format responses.
  * **Form Requests:** Centralized request validation, input normalization, and request authorization.
  * **Services:** 100% of domain rules, fare calculations, seat allocation, and database transaction management.
  * **Models:** Relational definitions, attribute casts, accessors/mutators, and query scopes only.
  * **Database:** Strict transactional integrity and row locking via MySQL InnoDB.
* **Database Transactions:** Owned exclusively by services (`BookingService`, `PaymentService`, `CouponService`); side-effects dispatched strictly post-commit.
* **Test Automation:** 100% of core business logic covered by automated Pest tests, including N+1 query prevention assertions.

---

## 9. Related Documents
* [`06-system-architecture.md`](./06-system-architecture.md) — Architectural patterns and service structure.
* [`07-database-design.md`](./07-database-design.md) — Schema definitions and constraints.
* [`15-security-guidelines.md`](./15-security-guidelines.md) — Detailed security practices.
* [`16-testing-strategy.md`](./16-testing-strategy.md) — Comprehensive test harness.
