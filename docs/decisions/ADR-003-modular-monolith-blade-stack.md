# ADR-003: Pragmatic Modular Monolith with Blade & Tailwind v4

## Status
**ACCEPTED** (Architectural Standard)

## Date
2026-11-03

## Context
Oliver Transport is an MVP scheduled shuttle platform with a strict 7-day development window. The technical lead team must select an implementation architecture that guarantees rapid delivery, high performance, robust testability, and operational simplicity.

Technical alternatives evaluated:
1. **Decoupled Single Page Application (SPA):** Laravel REST API backend + Next.js / Nuxt / React frontend.
2. **Microservices Architecture:** Independent services for Identity, Inventory, Booking, and Payments.
3. **Pragmatic Modular Monolith:** Standard Laravel 13 server-rendered application with Blade templates, Tailwind CSS v4, thin controllers, and dedicated Domain Services.

Evaluating the decoupled SPA and Microservices options against the project parameters:
* Microservices introduce massive operational complexity (distributed transactions, network latency, multiple deployments, service discovery) for an application with 1 vehicle and 6 seats.
* A decoupled SPA requires double routing, API contract maintenance, state hydration delays, complex SSR setups for SEO marketing pages, and split deployment pipelines.
* The verified existing repository is already configured with Laravel 13.39.0, PHP 8.4, Tailwind CSS v4, Vite 8, and Pest 5.3.

## Decision
We adopt a **Pragmatic Layered Monolith with Service-Oriented Architecture**:
1. **Full-Stack Laravel Monolith:** Server-rendered Blade views utilizing `@tailwindcss/vite` for styling. Routes handle URL mapping only; zero closures or database queries.
2. **Thin Controllers & Form Requests:** Controllers are strictly thin coordinators that type-hint dedicated Form Requests (`LoginRequest`, `CreateBookingRequest`, etc.) and delegate to services. Controllers never contain business rules or transaction management.
3. **Dedicated Domain Services:** 100% of business logic, pricing math, seat availability algorithms, and database transactions reside in `app/Services/` classes (`BookingService`, `PricingService`, `CouponService`, `PaymentService`, `SeatAvailabilityService`, `AuthenticationService`, `TripService`, `RiderService`).
4. **Relational MySQL Persistence & Model Integrity:** Eloquent models manage data, casts, query scopes, and relationships. Multi-step workflows inside models are prohibited.
5. **Mandatory Eager Loading & N+1 Prevention:** All relationship preloading (`with()`, `load()`, `withCount()`) is enforced before rendering Blade views; direct queries in Blade are strictly blocked. `Model::preventLazyLoading(!app()->isProduction())` is enabled in non-production.
6. **Service-Owned Transactions:** Database transactions are managed exclusively within relevant service classes; external notifications occur strictly post-commit.

## Consequences

### Positive Consequences
* **Rapid Delivery:** Eliminates API contract overhead and split deployments, ensuring feasibility within the 7-day milestone.
* **Instant SEO & Performance:** Zero hydration lag on public marketing pages; optimal search engine indexing for Montreal/Toronto shuttle searches.
* **Cohesive Testing:** Pest tests can execute end-to-end database, service, and HTTP assertions within a single memory space in seconds.

### Negative / Trade-Off Consequences
* **Native Mobile Apps:** In Phase 4, dedicated mobile API endpoints will need to be exposed alongside Blade routes. (The domain services will be directly reused).

