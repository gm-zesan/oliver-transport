# Oliver Transport — Antigravity Permanent Operating Manual

## 1. Project Identity & Operational Baseline

Oliver Transport is a scheduled intercity passenger shuttle service operating between **Montreal and Toronto, Canada**. The business provides daily, fixed-schedule, reserved-seat transportation connecting predefined stations in Montreal and Toronto with cash settlement upon boarding.

- **Primary Corridor**: Montreal (Station Métro Namur) ↔ Toronto (Yorkdale Mall & Yonge Station).
- **Exact 3 Stations**:
  1. `Station Métro Namur` (Montreal) — Route A boarding (6:30 AM); Route B final drop-off (~7:15 PM EST).
  2. `Yorkdale Mall` (Toronto) — Route A 1st drop-off; Route B 1st pickup (12:15 PM).
  3. `Yonge Station` (Toronto) — Route A 2nd drop-off; Route B 2nd pickup (1:15 PM).
- **Operating Fleet**: One (1) commercial minivan — Silver **Honda Odyssey** (License Plate: `RAJIA`).
- **Cabin Seating**: Exactly 7 seats: 1 Driver seat (permanently excluded from booking) + 6 Bookable Passenger Seats (`S1` front passenger window + `S2`–`S6` rear cabin).
- **Daily Fixed Schedule**: 7 days/week, 365 days/year. Timezone standard is strictly `America/Toronto` (Eastern Time).
- **Fare Model (`per_trip`)**: Flat rate per passenger per trip ($65.00 CAD regular, $55.00 CAD promotional launch rate). Multi-seat reservations multiply base fare (`base_fare * count(seats)`).
- **Multi-Seat Booking**: A single passenger account can book 1 to 6 seats in a single reservation without restriction.
- **Seat Selection (`choose`)**: Mandatory visual seat selection on an interactive vehicle cabin diagram. System never auto-assigns an alternate seat.
- **Settlement Model**: Cash-only collected physically by the Rider (driver) upon passenger boarding. Decoupled from booking confirmation (`confirmed` status with `unpaid` payment state).
- **In-App Cancellation & Booking Cutoff**: Strictly **excluded from MVP**. No in-app cancellation routes or cutoff deadlines exist for passengers.
- **Language**: English first for MVP launch. French localization deferred to Phase 2. Clean translation structure in `lang/en/`.
- **Confirmed Brand Assets**:
  - Logo: "Oliver" with dark charcoal "Ol" and vivid grass green "iver", uppercase "TRANSPORT", and subtitle "MONTREAL • TORONTO • MONTREAL".
  - Palette: Deep Obsidian (`#0B0F17`), Dark Slate (`#111827`), Oliver Green (`#22C55E`), Crisp White (`#FFFFFF`), Accent Red (`#EF4444`), Warning Gold (`#FBBF24`).
  - Contact: Phone/SMS/WhatsApp `647-655-1884` | Facebook: `Oliver Transport` (Verified).

---

## 2. Hierarchy of Truth & Documentation Priority

When developing, reviewing, or modifying any part of Oliver Transport, all agents must strictly adhere to the following priority order:

1. **Explicitly Confirmed User/Client Decisions**: Direct, authoritative instructions and approvals given in chat.
2. **Authoritative Project Documentation in `docs/`**: The detailed specifications (`docs/00` through `docs/19`, ADR-001 through ADR-004, `docs/README.md`).
3. **Root `AGENTS.md`**: This permanent operating manual and architectural governance document.
4. **Existing Codebase Implementation**: The existing code, provided it does not conflict with items 1–3 above.

### Decision Classification System
Every business and technical parameter belongs to one of four unambiguous categories:
- **`[CONFIRMED]`**: Mandated and approved by the user/client. Treat as immutable requirements.
- **`[PROPOSED]`**: Recommended architectural/default technical solutions that allow progress without delay. Subject to user adjustment.
- **`[PENDING]`**: Unresolved commercial or operational questions requiring explicit client direction.
- **`[FUTURE]`**: Explicitly excluded from MVP and reserved for subsequent phases (e.g., online Stripe checkout, self-service cancellations, French localization, admin analytics).

> **Cardinal Rule**: Never invent business rules or silently convert a `[PROPOSED]` or `[PENDING]` item into a confirmed rule. If an essential business decision is missing or ambiguous, ask the user before writing code.

---

## 3. Mandatory Documentation-First Workflow

Before beginning ANY implementation task, Antigravity must execute the following sequential workflow:

1. **Read `AGENTS.md`**: Refresh operating guidelines, architectural constraints, and project boundaries.
2. **Identify Relevant Documentation in `docs/`**:
   - High-level context: `docs/README.md`, `docs/00-project-overview.md`, `docs/01-project-scope.md`.
   - Business & functional logic: `docs/02-business-requirements.md`, `docs/03-functional-requirements.md`, `docs/04-non-functional-requirements.md`.
   - Architecture & database: `docs/06-system-architecture.md`, `docs/07-database-design.md`.
   - Core domain workflows: `docs/08-booking-workflow.md`, `docs/09-seat-management.md`, `docs/10-coupon-and-pricing.md`, `docs/11-rider-management.md`, `docs/12-payment-and-cancellation.md`.
   - UI/UX & routing: `docs/13-ui-ux-guidelines.md`, `docs/14-routes-and-navigation.md`.
   - Security & testing: `docs/15-security-guidelines.md`, `docs/16-testing-strategy.md`.
   - Architectural Decision Records: `docs/decisions/` (ADR-001, ADR-002, ADR-003, ADR-004).
3. **Read the Relevant Docs**: Never rely on memory from earlier turns or assume previous knowledge is sufficient. Re-read the target files.
4. **Check for Conflicts**: Cross-reference the requested task against architecture, database design, business rules, and phase requirements.
5. **Clarify Unresolved Items**: If requirements are missing, conflicting, or unconfirmed, ask the user before writing or modifying code.

---

## 4. Architectural Standards & Layered Responsibilities

Oliver Transport is architected as a **Service-Oriented Pragmatic Layered Laravel Monolith**:

$$\text{Routes} \longrightarrow \text{Form Requests} \longrightarrow \text{Controllers} \longrightarrow \text{Domain Services} \longrightarrow \text{Eloquent Models} \longrightarrow \text{Database}$$

### Strict Layer Responsibilities

1. **Routes (`routes/web.php`, `routes/auth.php`)**:
   - Define URL endpoints, HTTP verbs, middleware pipelines, and controller action mappings only.
   - **Zero business logic, zero database queries, zero closure route handlers**.
2. **Form Requests (`app/Http/Requests/`)**:
   - Own 100% of HTTP request input validation, type sanitization, custom error messages, and request-boundary authorization.
   - Controllers must never perform manual `$request->validate([...])`.
3. **Controllers (`app/Http/Controllers/`)**:
   - Thin request-response coordinators only.
   - Receive validated Form Requests, invoke injected Domain Services with primitive or DTO values, and return Blade views, HTTP redirects, or JSON responses.
   - Controllers never execute database queries, transactions, or domain calculations.
4. **Domain Services (`app/Services/`)**:
   - Encapsulate 100% of business logic, entity coordination, pricing calculations, and transaction orchestration.
   - Own database transactions explicitly (`DB::transaction()` or `DB::beginTransaction()` / `DB::commit()`).
   - Domain Services must never return HTTP responses, redirects, or Blade views. They return models, collections, or boolean/DTO results.
   - External side-effects (notifications, logs) must dispatch strictly **post-commit**.
5. **Eloquent Models (`app/Models/`)**:
   - Define table mappings, mass-assignment attributes (`$fillable`), type casts (`$casts`), relationships, and local query scopes.
   - Models must remain free of multi-step business workflows or orchestration logic.
6. **Blade Views & Presentation (`resources/views/`)**:
   - Presentation only. Pure UI rendering.
   - **Zero database queries permitted in Blade views or loops**.
   - Mandatory eager loading enforced via `Model::preventLazyLoading(! app()->isProduction())`. Controllers/Services must explicitly preload required relationships (`with()`, `loadMissing()`).

### Mobile-First UI/UX & Responsive Standards
- Baseline target: Mobile-first (iPhone Safari 360px+).
- Form inputs: Minimum 16px font size (`text-base` or `text-[16px]`) to eliminate iOS Safari auto-zoom disorientation.
- Interactive touch targets: Minimum 44×44 CSS pixels for standard controls; 48×48 CSS pixels for primary action buttons and seat tiles.
- Dynamic viewport & safe areas: Support `100dvh` and `env(safe-area-inset-*)` padding.

### Security & Role Authorization Boundaries
- Single shared login endpoint: `/login` for all roles (Passenger, Rider, Operator).
- Role-based post-login redirection based on `user.role` (`passenger.dashboard`, `rider.dashboard`, `operator.dashboard`).
- Server-side role authorization middleware (`role:operator`, `role:rider`, `role:passenger`) strictly enforced on all dashboard routes. Unauthorized access must return `HTTP 403 Forbidden`.
- Session security: Session fixation prevention via session regeneration on login/logout, strict password hashing (`bcrypt`), and route-level rate limiting.

---

## 5. Phase & Scope Governance

Development is strictly partitioned into distinct implementation phases:

- **Phase 1**: Project Foundation (Laravel architecture, base responsive layout, unified Breeze authentication, role redirects, role middleware, Pest foundation tests). `[COMPLETED]`
- **Phase 1.1**: Quality Review & Layout Standardization (Touch target verification, provisional branding tokens, layout consolidation, test suite verification). `[COMPLETED]`
- **Phase 2**: Database Foundation (13 tables, migrations, foreign keys, indexes, Eloquent models, model factories, deterministic seeders). `[COMPLETED]`
- **Phase 3**: Core Booking & Seat Allocation Engine (Pessimistic concurrency locking, segment-based seat availability, fare calculation, multi-seat booking, instant confirmation). `[UPCOMING]`
- **Phase 4**: Rider Mobile Panel & Manifest (Passenger check-in, cash collection logging, trip status tracking). `[UPCOMING]`
- **Phase 5**: Operator Dashboard & Schedule Management (Daily trip generation, manifest overview, coupon management). `[UPCOMING]`
- **Phase 6**: Notifications & End-to-End System Polish (SMS/Email triggers, production hardening). `[UPCOMING]`

> **Scope Control Mandate**: Strictly adhere to the scope of the requested phase. When a prompt asks for Phase N, implement ONLY Phase N. Never bleed into or partially implement future phases without explicit user instruction.

---

## 6. Documentation Synchronization Policy

- Whenever an implementation refines, updates, or establishes new concrete behaviors with user approval, the corresponding documentation in `docs/` must be synchronized immediately.
- Update `docs/decisions/ADR-004-pending-client-decisions-log.md` when decisions transition from `[PENDING]` or `[PROPOSED]` to `[CONFIRMED]`.
- Update architectural diagrams, route maps, or database docs if schemas or endpoints evolve.
- Never leave stale, contradictory, or out-of-sync documentation behind in the repository.

---

## 7. Verification & Code Quality Standards

Before completing ANY implementation or maintenance task, execute the full verification protocol:

1. **Automated Tests**:
   - Run Pest tests: `php artisan test` or `./vendor/bin/pest`.
   - Ensure 100% of tests pass. Report test counts and assertion counts.
   - When new features or bug fixes are introduced, add comprehensive Pest feature/unit tests.
2. **Code Style & Formatting**:
   - Run Laravel Pint: `./vendor/bin/pint --format agent`.
   - Ensure zero formatting or styling violations remain.
3. **Frontend Compilation**:
   - If views, CSS, or JS are modified, compile assets: `npm run build`.
   - Verify that Vite builds cleanly without warnings or errors.
4. **Database Verification**:
   - Ensure all migrations and seeders execute without error: `php artisan migrate:fresh --seed` (in local/testing environments).

---

## 8. Mandatory Task Lifecycle Protocols

### Protocol A: Required Task-Start Summary
At the beginning of every task, before writing or modifying any code, provide a concise summary with:
1. **Documentation Consulted**: Specific files in `docs/` reviewed for this task.
2. **Scope of the Current Task**: Explicit boundaries of what will and will not be implemented.
3. **Confirmed Decisions Applied**: Key client-confirmed specifications governing this task.
4. **Clarifications Needed**: Any ambiguous, missing, or conflicting requirements needing user sign-off (or state "None" if requirements are complete).

### Protocol B: Required Final Report
At the completion of every task, provide a structured final report detailing:
1. **Summary of Implementation**: What was built, refactored, or established.
2. **Files Created or Modified**: Clear list of paths with clickable links.
3. **Decisions Applied**: Specific confirmed rules or defaults adhered to.
4. **Verification Results**: Pest test results (test count, assertion count), Pint check, and Vite build output.
5. **Next Logical Steps**: The immediate subsequent phase or recommended action.
6. **Open Questions / Decisions Needed**: Items requiring user input before proceeding to the next step.

---

## 9. Laravel Boost & Technical Tooling Standards

This application is built on **Laravel 12 / 13** on **PHP 8.4** with **Tailwind CSS v4** and **Pest PHP**.

- **PHP 8.4 Standards**:
  - Always use curly braces for control structures.
  - Use constructor property promotion: `public function __construct(public BookingService $bookingService) {}`.
  - Declare strict types where appropriate, and always use explicit parameter types and return type declarations on all methods.
  - Use TitleCase for Enum keys (`Confirmed`, `Cancelled`, `Pending`).
  - Use PHPDoc blocks for complex structures and array shapes (`/** @param array{seat_ids: int[], ...} $data */`).
- **Artisan Best Practices**:
  - Always pass `--no-interaction` to Artisan commands in automation.
  - Generate files using standard Artisan generators: `php artisan make:model`, `php artisan make:controller`, `php artisan make:request`, `php artisan make:service` (or make:class), `php artisan make:test --pest`.
- **Database Rules**:
  - Store monetary amounts as integer minor units (cents) or safe fixed decimals (e.g. `fare_amount_cents = 6500`).
  - MySQL 8.0 InnoDB compatible schemas; SQLite supported in-memory for lightning-fast Pest testing.
  - Never seed real customer information or hardcoded production credentials.
- **Laravel Boost MCP Integration**:
  - Use `database-query` for read-only database inspections.
  - Use `database-schema` to inspect table structures before writing models/migrations.
  - Use `search-docs` when consulting official Laravel ecosystem package features.
