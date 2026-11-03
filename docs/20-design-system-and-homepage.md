# 20 — Design System & Homepage Implementation (Phase 3.1)

## 1. Document Overview & Purpose
This document establishes the official visual design system and records the architectural implementation of the public homepage for **Oliver Transport** (Phase 3.1). It captures the color palette, typography hierarchy, responsive touch guidelines, reusable Blade components, and homepage layout structure, adhering to the client-provided branding reference and the layered Laravel monolithic architecture.

---

## 2. Branding Reference Analysis & Vehicle Decal

### 2.1 Authentic Client Asset Inspection
The visual branding is anchored in the client's official marketing photograph and promotional poster (`public/images/oliver-transport-poster-en.jpg` and `public/images/oliver-transport-poster-fr.jpg`).

* **Operating Vehicle:** Commercial Silver Honda Odyssey minivan, Ontario License Plate **RAJIA**.
* **Wordmark Decal (Vehicle Door):**
  * "Ol" rendered in dark charcoal / near black.
  * "iver" rendered in vivid lime / grass green (with distinctive green dot above the 'i').
  * "TRANSPORT" rendered in bold uppercase sans-serif with horizontal rule accents.
  * Subtitle: "MONTREAL • TORONTO • MONTREAL" in uppercase sans-serif with dot separators.
* **Vehicle Asset Status (`[REPORTED]`):**
  * The authentic promotional poster image is ingested and hosted at `public/images/oliver-transport-poster-en.jpg`.
  * An isolated, transparent-background cut-out of the Honda Odyssey minivan alone (without marketing poster overlay text) is **not present** as a distinct asset in the repository. Per instruction, no unrelated stock vehicle images have been substituted, and no fictional asset paths have been generated. The authentic poster image is presented cleanly within a vehicle specification card on the homepage.

---

## 3. Visual Design System & Design Tokens

### 3.1 Color Palette & Token Definitions
The website design system adopts a **clean, professional, high-contrast light presentation** (white and subtle neutral surfaces with dark readable typography), avoiding excessive flyer decorations, neon glows, or heavy drop shadows:

| Token Name | Hex Value | Semantic Role | Notes |
|---|---|---|---|
| `--color-brand-green` | `#16A34A` | Primary Brand Green & CTA Action | Matches vehicle door decal; passes WCAG AA 4.5:1 on white. |
| `--color-brand-green-hover` | `#15803D` | Primary Action Hover State | Darker green for interactive feedback. |
| `--color-brand-green-light` | `#DCFCE7` | Subtle Green Tint | Badge and container borders. |
| `--color-brand-green-subtle` | `#F0FDF4` | Neutral Green Surface | Soft background fills for highlights. |
| `--color-brand-charcoal` | `#111827` | Secondary Brand Base | Vehicle decal charcoal and footer background. |
| `--color-brand-charcoal-hover` | `#1F2937` | Secondary Hover State | Interactive dark element hover. |
| `--color-brand-dark` | `#0F172A` | Deep Slate | High-contrast heading typography. |
| `--color-brand-yellow` | `#EAB308` | Accent Highlight (Used Sparingly) | Badge highlights and departure indicators. |
| `--color-brand-yellow-light` | `#FEF9C3` | Subtle Accent Tint | Accent indicator surfaces. |
| `--color-brand-red` | `#DC2626` | Promotional Accent & Alert | Warning badges and notice indicators. |
| `--color-brand-red-light` | `#FEE2E2` | Alert Tint | Flash error message background. |
| `--color-surface-white` | `#FFFFFF` | Core Page Background | Pure white surface for maximum readability. |
| `--color-surface-subtle` | `#F8FAFC` | Secondary Card / Section Surface | Slate 50 subtle background. |
| `--color-surface-muted` | `#F1F5F9` | Neutral Surface Alternative | Slate 100 section separation. |
| `--color-surface-border` | `#E2E8F0` | Default Border & Divider | Slate 200 border for cards and inputs. |
| `--color-content-primary` | `#0F172A` | Primary Heading & Body Text | Slate 900 high-contrast copy. |
| `--color-content-secondary` | `#334155` | Secondary Descriptive Text | Slate 700 readable narrative text. |
| `--color-content-muted` | `#64748B` | Captions, Hints, & Metadata | Slate 500 secondary labels. |

Tokens are registered centrally in `resources/css/app.css` within the Tailwind CSS v4 `@theme` directive. Backward-compatible aliases (`--color-provisional-*`) are retained to prevent disruption to existing authenticated portals.

### 3.2 Typography & Numerical Formatting
* **Font Family:** `Instrument Sans` via Bunny Fonts (loaded via Vite), falling back to clean system sans-serif stacks.
* **Monospaced Numerals:** `font-mono` applied to times (`6:30 AM`), prices (`$65 CAD`), license plate (`RAJIA`), and seat codes (`S1`–`S6`).
* **Input Font Size Safeguard:** Strict `16px` (`text-base` / `1rem !important`) enforced across all `<input>`, `<select>`, and `<textarea>` elements to eliminate iOS Safari auto-zoom disorientation.

### 3.3 Touch Targets & Responsive Layout Ergonomics
* **Primary Interactive Controls:** Minimum **48 × 48 CSS pixels** for all primary action buttons and CTAs.
* **Standard Interactive Controls:** Minimum **44 × 44 CSS pixels** for navigation links, buttons, and form controls (Apple Human Interface Guidelines).
* **Dynamic Viewport Height:** Full-screen mobile heights utilize `min-h-[100dvh]` with `100vh` fallback.
* **Safe-Area Insets:** Top and bottom spacing account for `env(safe-area-inset-top)` and `env(safe-area-inset-bottom)`.

---

## 4. Reusable Blade Components

The design system establishes the following modular components under `resources/views/components/` and layouts under `resources/views/layouts/`:

1. `<x-layouts.app>` & `<x-layouts.guest>` (`resources/views/layouts/`):
   * Located directly in `resources/views/layouts/` (outside `components/`), mapped via dedicated component classes `App\View\Components\Layouts\App` and `App\View\Components\Layouts\Guest`.
2. `<x-brand-logo>` (`components/brand-logo.blade.php`):
   * Renders the authentic Oliver Transport wordmark: dark charcoal "Ol" + green "iver" + bold "TRANSPORT" + optional subtitle "MONTREAL • TORONTO • MONTREAL".
   * Accepts `:inverted="true|false"` (for dark footers vs light headers) and `size="sm|md|lg"`.
3. `<x-navigation>` (`components/navigation.blade.php`):
   * Responsive sticky header with brand mark, anchor navigation links, quick phone support button (`647-655-1884`), guest CTAs ("Sign In" and "Book Your Seat"), authenticated dashboard shortcut, and an accessible mobile hamburger drawer.
4. `<x-footer>` (`components/footer.blade.php`):
   * Comprehensive footer with inverted branding, route summaries, confirmed customer support channels (Telephone/SMS/WhatsApp: `647-655-1884`, Facebook: `Oliver Transport`), and copyright notices.
5. `<x-section-heading>` (`components/section-heading.blade.php`):
   * Reusable section header featuring an uppercase pill badge/eyebrow, prominent `h2` heading, and descriptive subtitle.
6. `<x-route-info>` (`components/route-info.blade.php`):
   * Dual-route card grid displaying Route A (Montreal → Toronto, 6:30 AM departure from Station Métro Namur to Yorkdale Mall and Yonge Station) and Route B (Toronto → Montreal, pickups at Yorkdale Mall 12:15 PM and Yonge Station 1:15 PM). Adheres strictly to displaying only confirmed stations.
7. `<x-fare-card>` (`components/fare-card.blade.php`):
   * Transparent pricing card highlighting the confirmed standard flat rate of **CAD $65** per passenger per trip, cash payment on boarding terms, and feature list (reserved seat, luggage, minivan comfort, multi-seat capability).
8. `<x-card>` (`components/card.blade.php`):
   * Light surface container with border, rounded corners (`rounded-2xl`), and subtle elevation.
9. `<x-form-input>` (`components/form-input.blade.php`):
   * Mobile-safe form input component with label, hint, error states, and 48px height with 16px font size.
10. `<x-primary-button>` & `<x-secondary-button>`:
   * Updated with authoritative design tokens, 48px minimum touch targets, and accessible focus states.

The public frontend architecture is organized into a modular layout and partials hierarchy under `resources/views/frontend/` (also symlinked directly at `resources/frontend/`):

1. **Frontend Layout (`resources/views/frontend/layout/app.blade.php`)**:
   * Master HTML boilerplate incorporating `@include('frontend.partials.favicon')`, `@include('frontend.partials.styles')`, `@include('frontend.partials.header')`, flash session banners, main content slot/yield, `@include('frontend.partials.footer')`, and `@include('frontend.partials.script')`.
2. **Frontend Partials (`resources/views/frontend/partials/`)**:
   * [`favicon.blade.php`](file:///Users/zesan/Desktop/My-Work/oliver-transport/resources/views/frontend/partials/favicon.blade.php) — Favicon and apple touch icon links.
   * [`styles.blade.php`](file:///Users/zesan/Desktop/My-Work/oliver-transport/resources/views/frontend/partials/styles.blade.php) — Fonts preconnect, Instrument Sans stylesheet, Vite asset bundle, and `@stack('styles')`.
   * [`header.blade.php`](file:///Users/zesan/Desktop/My-Work/oliver-transport/resources/views/frontend/partials/header.blade.php) — Sticky glassmorphic navigation header with Oliver Transport brand mark, anchor links, phone support pill (`647-655-1884`), guest auth CTAs, authenticated dashboard links, and mobile menu drawer.
   * [`footer.blade.php`](file:///Users/zesan/Desktop/My-Work/oliver-transport/resources/views/frontend/partials/footer.blade.php) — Dark charcoal site footer with inverted brand mark, corridor timetables, confirmed support channels (`647-655-1884`, Facebook `Oliver Transport`), and copyright notices.
   * [`script.blade.php`](file:///Users/zesan/Desktop/My-Work/oliver-transport/resources/views/frontend/partials/script.blade.php) — Mobile menu toggle logic, interactive hero route switcher (`switchHeroRoute`), and `@stack('scripts')`.
3. **Frontend Page (`resources/views/frontend/index.blade.php`)**:
   * Uses `@extends('frontend.layout.app')` and `@section('content')`.
   * Contains Hero, Interactive Route & Timetable switcher, Transparent Fares, 3-Step How It Works, Why Choose Us, and Final Booking CTA.

---

## 5. Homepage Structure & Implementation Details

The public homepage is rendered via `App\Http\Controllers\Frontend\HomeController@index` at `GET /` (`resources/views/frontend/index.blade.php`):

1. **Header & Navigation:** Sticky glassmorphic top bar with brand logo, smooth scroll anchor links (`#routes`, `#fares`, `#how-it-works`, `#why-us`, `#contact`), direct call support button, and responsive mobile drawer.
2. **Hero Section:**
   * Value Proposition: "Montreal to Toronto. Scheduled. Reserved. Direct."
   * Interactive Trip Intent Widget: Tabbed direction selector (`Montreal → Toronto` vs `Toronto → Montreal`) allowing passengers to inspect scheduled departure and drop-off stations with immediate fare display.
   * Executive Fleet & Visual Cabin Layout Preview: Features the Silver Honda Odyssey (Ontario RAJIA) alongside an interactive 6-passenger cabin layout diagram showing Seat S1, S2–S3 captain chairs, and S4–S6 rear seating, communicating Oliver Transport's visual seat selection model.
3. **Route Information (`#routes`):**
   * Visual timeline cards for Route A and Route B with scheduled times and transfer connections.
4. **Transparent Fares (`#fares`):**
   * Authoritative CAD $65 regular fare display. Clarifies cash-on-boarding settlement model without inventing unconfirmed promotional dates.
5. **How It Works (`#how-it-works`):**
   * 3-step walkthrough: 1. Select Trip & Seat → 2. Instant Reservation → 3. Board & Pay Cash.
6. **Why Choose Oliver Transport (`#why-us`):**
   * Communicates strictly confirmed service features: Fixed daily schedule, manual visual seat choice, commercial minivan comfort, cash settlement on boarding, central station connectivity, and multi-seat reservation support.
7. **Final Booking Call-to-Action:**
   * High-contrast conversion banner directing passengers to secure their seats in advance, with direct telephone inquiry channels (`647-655-1884`).
8. **Footer (`#contact`):**
   * Inverted brand mark, daily corridor timetables, confirmed contact details, and copyright.

---

## 6. Pending Decisions & Next Steps

1. **Vehicle Isolated Cut-Out Asset:** Request transparent PNG/SVG cut-out of the minivan from the client for enhanced hero section graphics in future phases.
2. **Route B Montreal Drop-off Confirmation:** The client has confirmed Station Métro Namur in ADR-004, while `docs/02-business-requirements.md` logs PD-001 as pending. Homepage currently refers to central Montreal arrival without displaying unconfirmed specific addresses.
3. **Promotional Launch Fare Window:** Confirm active duration and expiration date of the $55 CAD promotional launch rate before enabling promotional pricing countdown banners.

