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
   * [`header.blade.php`](file:///Users/zesan/Desktop/My-Work/oliver-transport/resources/views/frontend/partials/header.blade.php) — Dynamic navigation header sitting transparent and hero-aligned at initial load with white text over the luminous cinematic video, transitioning smoothly into a floating frosted glass pill capsule on scroll, featuring the Oliver Transport automotive motion logo, navigation links (`Home`, `Services`, `About`, `Contact`), clean guest auth CTAs ("Sign In" and "Book Now"), and responsive mobile drawer.
   * [`footer.blade.php`](file:///Users/zesan/Desktop/My-Work/oliver-transport/resources/views/frontend/partials/footer.blade.php) — Premium Dark Charcoal (`#111827`) 4-column footer featuring inverted automotive motion brand mark with "Montreal • Toronto • Montreal", Quick Links (`Home`, `Services`, `About`, `Contact`), Contact Us directory (`647-655-1884`, `info@olivertransport.ca`, Montreal/Toronto hubs), green CTA booking panel, copyright, and legal links.
   * [`script.blade.php`](file:///Users/zesan/Desktop/My-Work/oliver-transport/resources/views/frontend/partials/script.blade.php) — Mobile menu toggle logic, dynamic header scroll state transition (`updateHeaderStyles`), interactive hero route switcher (`switchHeroRoute`), Uber-style floating label dropdown selectors (`selectPickup`, `selectDestination`), and auth prompt modal dialog handlers (`openAuthModal`, `closeAuthModal`).
3. **Frontend Page (`resources/views/frontend/index.blade.php`)**:
   * Uses `@extends('frontend.layout.app')` and `@section('content')`.
   * Follows the 6-section hybrid design architecture:
     1. **Hero:** Full-width luminous cinematic video background with refined gradient overlays, high-impact typography with green accent bar, and dark translucent glass booking form.
     2. **Our Services:** Pure white background (`#FFFFFF`) with 2 realistic corridor service cards tailored strictly to Oliver Transport's 3-location passenger ride-share service (Route A & Route B), featuring \$65 CAD flat fare, cash settlement on boarding, and direct booking actions.
     3. **Why Choose Us:** Soft green-tinted background (`#F0FDF4`) with 4 horizontal benefit items and thin separators.
     4. **Vehicle Showcase:** Wide vehicle showcase card (inspired by reference image) highlighting the Silver Honda Odyssey (Plate: RAJIA), 6 passenger seats, features checklist, and \$65 flat fare notice.
     5. **Corridor FAQ Accordion:** Clean accordion answering passenger questions on payment, luggage, pickup hubs, and schedules.
     6. **Footer:** Dark charcoal background (`#111827`) 4-column footer with green CTA card.
     7. **Separate Contact Page (`/contact`):** Dedicated page featuring verified phone, email, corridor stations, and interactive inquiry form.

---

## 5. Homepage Structure & Implementation Details

The public homepage is rendered via `App\Http\Controllers\Frontend\HomeController@index` at `GET /` (`resources/views/frontend/index.blade.php`):

1. **Header & Navigation:** Dynamic floating pill capsule navbar positioned over the dark hero section, transitioning from transparent to frosted white on scroll.
2. **Hero Section:**
   * **Cinematic Video Ride Loop:** Ambient video ride loop playing with dark gradient overlays (`from-[#111827]/95 via-[#111827]/85 to-[#111827]/60`).
   * **Left Column:** Styled directly from visual reference: horizontal green accent bar followed by "PREMIUM TRANSPORTATION SERVICE", dominant two-line headline ("Your Journey," in white, "Our Priority." in vivid `#22C55E`), bold subtitle ("Travel in Comfort. Arrive in Style."), and two-line description bounded by an authentic vertical green accent line.
   * **Translucent Glass Booking Panel:** Dark semi-transparent glass panel (`bg-[#111827]/75 backdrop-blur-2xl border border-white/15`), Route A / Route B toggle tabs, Uber-style custom dropdown selectors with animated floating labels, and high-conversion green CTA button.
   * **Guest Login Modal:** Clean modal appearing if an unauthenticated user submits the booking form.
3. **Our Services Section (`#services`):**
   * Two-column header ("Services" headline on left, invitation text on right) with a 2x2 grid of horizontal cards (`bg-[#F1F3F7]`) featuring professional photography on the left, service narrative, and dark slate "Read More" CTA buttons.
4. **Why Choose Us Section (`#why-us`):**
   * Soft green-tinted section (`#F0FDF4`) presenting 4 core benefits with green outline icons and horizontal separators.
5. **About Oliver Transport Section (`#about`):**
   * Spacious 2-column layout with verified Honda Odyssey minivan photograph (plate RAJIA, 6 Passenger Seats) and "Learn More" green CTA.
6. **Contact Us Section (`#contact`):**
   * Light background (`#F8FAFC`) with phone `647-655-1884`, email `info@olivertransport.ca`, Montreal & Toronto station hubs, and contact inquiry form.
7. **Footer:**
   * Dark charcoal (`#111827`) 4-column footer with brand logo, quick links, contact channels, and a green CTA panel.

---

## 6. Pending Decisions & Next Steps

1. **Vehicle Isolated Cut-Out Asset:** Request transparent PNG/SVG cut-out of the minivan from the client for enhanced hero section graphics in future phases.
2. **Route B Montreal Drop-off Confirmation:** The client has confirmed Station Métro Namur in ADR-004, while `docs/02-business-requirements.md` logs PD-001 as pending. Homepage currently refers to central Montreal arrival without displaying unconfirmed specific addresses.
3. **Promotional Launch Fare Window:** Confirm active duration and expiration date of the $55 CAD promotional launch rate before enabling promotional pricing countdown banners.

