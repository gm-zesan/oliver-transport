# Architectural Decision Records (ADR) & Decisions Log

## 1. Directory Purpose
This directory records the formal Architectural Decision Records (ADRs) and the comprehensive **Pending Client Decisions Registry** for Oliver Transport. It captures the context, architectural options evaluated, final decisions, and operational consequences governing the platform design.

---

## 2. Decision Records Index

| Reference | Title | Status | Date | Primary Driver |
|---|---|:---:|---|---|
| [`ADR-001`](./ADR-001-segment-based-seat-allocation.md) | **Segment-Based Seat Allocation vs. Trip-Wide Boolean** | **ACCEPTED** | 2026-11-03 | Prevent overbooking while enabling non-overlapping seat reuse across multi-stop routes. |
| [`ADR-002`](./ADR-002-cash-only-payment-lifecycle.md) | **Cash-Only Settlement & Independent Payment Lifecycle** | **ACCEPTED** | 2026-11-03 | Decouple reservation guarantee from physical cash collection without online gateways in MVP. |
| [`ADR-003`](./ADR-003-modular-monolith-blade-stack.md) | **Pragmatic Modular Monolith with Blade & Tailwind v4** | **ACCEPTED** | 2026-11-03 | Maximize developer velocity, zero SPA hydration lag, leverage verified Laravel 13 stack. |
| [`ADR-004`](./ADR-004-pending-client-decisions-log.md) | **Comprehensive Pending Client Decisions Registry** | **AUDITED & LOGGED** | 2026-11-03 | Catalog of 17 business decisions requiring client confirmation with proposed defaults. |

---

## 3. Pending Client Decisions Summary

The following 17 business decisions require formal validation from the client. Reasonable, non-blocking defaults have been proposed by the technical lead team to allow MVP development to proceed without delay:

| Ref # | Decision Area | Current Status | Proposed Default for MVP |
|:---:|---|:---:|---|
| **PD-01** | **Route B Final Montreal Drop-off Address** | **`[PENDING]`** | **Station Metro Namur** (symmetric with Route A departure). |
| **PD-02** | **Vehicle Passenger Capacity Interpretation** | **`[CONFIRMED]`** | **6 Passengers** bookable; 1 Driver seat permanently excluded. |
| **PD-03** | **Promotional $55 CAD Rate Expiry Date** | **`[PENDING]`** | Active through launch window; controlled via `config/pricing.php`. |
| **PD-04** | **Coupon Application: Per-Passenger vs. Per-Booking** | **`[PROPOSED]`** | **Per-Booking** (1 booking = 1 seat in MVP). |
| **PD-05** | **Coupon Stacking Policy** | **`[PROPOSED]`** | **Zero Stacking**. Exactly one valid coupon allowed per booking. |
| **PD-06** | **Default Coupon Usage Limits** | **`[PROPOSED]`** | Default: `1` redemption per passenger; global cap set per campaign. |
| **PD-07** | **Passenger Self-Service Cancellation Rights** | **`[PENDING]`** | **Permitted** up to the cancellation cutoff deadline via dashboard. |
| **PD-08** | **Cancellation Deadline Threshold** | **`[PENDING]`** | **2 Hours** prior to scheduled departure. |
| **PD-09** | **Future Refund Policy Framework** | **`[FUTURE]`** | Staged for Phase 3 alongside online payment gateway integration. |
| **PD-10** | **Cash Payment Confirmation Procedure** | **`[PROPOSED]`** | Assigned Rider taps "Collect Cash" on mobile manifest at boarding. |
| **PD-11** | **Booking Cutoff Threshold Before Departure** | **`[PENDING]`** | **30 Minutes** proposed default, pending client confirmation. |
| **PD-12** | **Minimum Passenger Details for Booking** | **`[CONFIRMED]`** | Full Name, Verified Email, Canadian/E.164 Contact Phone Number. |
| **PD-13** | **Multiple Seats per Booking** | **`[PROPOSED]`** | **1 Seat per Booking** in MVP; eliminates complex partial cancellations. |
| **PD-14** | **Individual Seat Selection Requirement** | **`[CONFIRMED]`** | Every passenger visually selects their exact physical cabin seat (S1–S6). |
| **PD-15** | **Bilingual (English/French) UI Requirement** | **`[PROPOSED]`** | Translation-ready architecture (`lang/en`, `lang/fr`) with header toggle. |
| **PD-16** | **Rider Account Provisioning Without Admin Panel** | **`[PROPOSED]`** | Secure Artisan command (`php artisan make:rider`) executed by operator. |
| **PD-17** | **Estimated Montreal Arrival Time for Route B** | **`[PROPOSED]`** | **~7:15 PM Eastern Time** displayed as estimated arrival for travelers. |

---

## 4. ADR Management Guidelines

1. **Immutability:** Once an ADR is marked `ACCEPTED`, its context and decision cannot be edited retroactively. If a decision changes, create a new ADR that references and supersedes the former.
2. **Contextual Rigor:** Every ADR must clearly document the business context, technical trade-offs, and consequences (both positive and negative).
3. **Classification Integrity:** A proposed default must never be marked `[CONFIRMED]` without explicit client sign-off.
