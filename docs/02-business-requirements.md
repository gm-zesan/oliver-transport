# 02 — Business Requirements

## 1. Document Purpose
This document specifies the exact business rules, operating constraints, geographic locations, schedule timings, and route configurations governing the Oliver Transport shuttle service.

---

## 2. Scope
* **In Scope:** The geographic and operational definition of the Montreal ↔ Toronto corridor, including the 3 fixed station hubs, 2 operational route sequences, daily recurring schedules, and timezone governance.
* **Out of Scope:** Custom door-to-door pickups, dynamic waypoint insertion, driver detours, and multi-city route permutations.

---

## 3. Relevant Requirements

| ID | Requirement | Classification | Notes |
|---|---|---|---|
| BRQ-01 | Predefined Location 1: Metro Namur (Montreal) | **`[CONFIRMED]`** | Starting point for Montreal → Toronto trips. |
| BRQ-02 | Predefined Location 2: Yorkdale Mall (Toronto) | **`[CONFIRMED]`** | First drop-off for Route A; first pickup for Route B. |
| BRQ-03 | Predefined Location 3: Yonge Station (Toronto) | **`[CONFIRMED]`** | Second drop-off for Route A; second pickup for Route B. |
| BRQ-04 | Route A fixed departure: 6:30 AM | **`[CONFIRMED]`** | Departs Metro Namur daily at 06:30 America/Toronto. |
| BRQ-05 | Route B fixed pickups: 12:15 PM & 1:15 PM | **`[CONFIRMED]`** | 12:15 PM Yorkdale Mall; 1:15 PM Yonge Station daily. |
| BRQ-06 | 7-day-a-week daily operations | **`[CONFIRMED]`** | 365 days/year operation with independent daily Trip records. |
| BRQ-07 | Operational Timezone `America/Toronto` | **`[CONFIRMED]`** | Strict Eastern Time compliance (EST/EDT). |
| BRQ-08 | Prohibition of arbitrary stops or schedule modifications | **`[CONFIRMED]`** | Neither passengers nor riders can alter routes, stops, or times. |
| BRQ-09 | Final Montreal drop-off address for Route B | **`[CONFIRMED]`** | Station Métro Namur (Montreal). Total 3 locations in system. |
| BRQ-10 | Final Montreal arrival time for Route B | **`[PROPOSED]`** | Estimated arrival ~7:15 PM proposed for UI display with traffic disclaimer. |
| BRQ-11 | Multi-Seat Booking under 1 Account | **`[CONFIRMED]`** | Passenger can book multiple seats (1 to 6) in a single transaction. |
| BRQ-12 | No Booking Cutoff Gate in MVP | **`[CONFIRMED]`** | Bookings accepted up to departure time as long as seats exist. |
| BRQ-13 | No In-App Cancellation System in MVP | **`[CONFIRMED]`** | Handled out-of-band via phone/SMS (`647-655-1884`) or Facebook. |

---

## 4. Geographic Hubs & Predefined Locations

The platform is strictly bounded to three (3) physical hub locations in the MVP.

```mermaid
graph LR
    subgraph Montreal["Montreal Area"]
        L1["Hub 1: Metro Namur<br/>(Station Namur, Montreal, QC)"]
    end

    subgraph Toronto["Toronto Area"]
        L2["Hub 2: Yorkdale Mall<br/>(Toronto, ON)"]
        L3["Hub 3: Yonge Station<br/>(Yonge & Bloor / Yonge St, Toronto, ON)"]
    end

    L1 ===|"Route A (Morning): 6:30 AM"|===> L2
    L2 ===|"Route A (Local Segment)"|===> L3
    L2 ===|"Route B (Afternoon Pickup 1): 12:15 PM"|===> L3
    L3 ===|"Route B (Afternoon Pickup 2): 1:15 PM"|===> L1
```

### Location Details Table

| ID | Location Name | City, Province | Operational Function (Route A) | Operational Function (Route B) | Status |
|---|---|---|---|---|---|
| **LOC-1** | **Metro Namur** | Montreal, QC | Origin / Boarding Hub (6:30 AM) | Final Drop-off Hub | **`[CONFIRMED]`** |
| **LOC-2** | **Yorkdale Mall** | Toronto, ON | First Drop-off Station | First Pickup Hub (12:15 PM) | **`[CONFIRMED]`** |
| **LOC-3** | **Yonge Station** | Toronto, ON | Final Drop-off Station | Second Pickup Hub (1:15 PM) | **`[CONFIRMED]`** |

---

## 5. Route Definitions & Stop Sequences

The platform models each direction as an ordered sequence of stops. Stop sequence numbers are critical integers used by the segment-based seat allocation algorithm to validate permissible journeys and evaluate overlaps.

### 5.1 Route A: Montreal → Toronto (Morning Service)

* **Route Direction:** Montreal to Toronto (`MTL_TO_TOR`)
* **Operating Schedule:** Departs daily at **6:30 AM Eastern Time**.
* **Ordered Stop Hierarchy:**

| Sequence Index | Location Name | Action Permitted | Scheduled Operational Time | Stop Type |
|---|---|---|---|---|
| `0` | Metro Namur, Montreal | **Boarding Only** | 6:30 AM (Departure) | Origin Hub |
| `1` | Yorkdale Mall, Toronto | **Drop-off Only** | ~11:30 AM - 12:00 PM (Est.) | Intermediate Station |
| `2` | Yonge Station, Toronto | **Drop-off Only** | ~12:15 PM - 12:45 PM (Est.) | Final Terminus |

#### Allowed Booking Combinations (Route A):
A passenger on Route A may book only the following valid stop pairs:
1. **Metro Namur (`0`) → Yorkdale Mall (`1`)**: Segment `[0, 1]` — Full `per_trip` base fare applies.
2. **Metro Namur (`0`) → Yonge Station (`2`)**: Segment `[0, 2]` — Full `per_trip` base fare applies.
3. **Yorkdale Mall (`1`) → Yonge Station (`2`)**: Segment `[1, 2]` — Full `per_trip` base fare applies (no distance discounts).

*Disallowed Combinations:* Reverse travel (e.g., Yorkdale → Metro Namur on Route A) or identical pickup/drop-off.

---

### 5.2 Route B: Toronto → Montreal (Afternoon Service)

* **Route Direction:** Toronto to Montreal (`TOR_TO_MTL`)
* **Operating Schedule:** Pickups at **12:15 PM** and **1:15 PM Eastern Time**.
* **Ordered Stop Hierarchy:**

| Sequence Index | Location Name | Action Permitted | Scheduled Operational Time | Stop Type |
|---|---|---|---|---|
| `0` | Yorkdale Mall, Toronto | **Boarding Only** | 12:15 PM (Sharp) | Origin Hub 1 |
| `1` | Yonge Station, Toronto | **Boarding Only** | 1:15 PM (Sharp) | Origin Hub 2 |
| `2` | Metro Namur, Montreal | **Drop-off Only** | ~6:45 PM - 7:30 PM (Est.) | Final Terminus |

#### Allowed Booking Combinations (Route B):
A passenger on Route B may book only the following valid stop pairs:
1. **Yorkdale Mall (`0`) → Metro Namur (`2`)**: Segment `[0, 2]` — Full `per_trip` base fare applies.
2. **Yonge Station (`1`) → Metro Namur (`2`)**: Segment `[1, 2]` — Full `per_trip` base fare applies.
3. **Yorkdale Mall (`0`) → Yonge Station (`1`)**: Segment `[0, 1]` — Full `per_trip` base fare applies (no distance discounts).

*Disallowed Combinations:* Reverse travel (e.g., Montreal → Toronto on Route B) or identical pickup/drop-off.

---

## 6. Daily Cadence & Schedule Architecture

### 6.1 Recurring Schedules vs. Dated Trips
A critical architectural principle is the strict separation between a **Recurring Schedule** (the abstract timetable template) and a **Dated Trip** (a concrete operational run on a specific calendar date).

```
+--------------------------------------------------------------------+
| Schedule Template (ID: SCH-001)                                    |
| Direction: Montreal -> Toronto | Departs: 06:30:00                 |
+--------------------------------------------------------------------+
                                  |
                                  | Instantiates daily
                                  v
+--------------------------------------------------------------------+
| Trip Instance (ID: 101)        | Trip Instance (ID: 102)          |
| Date: 2026-11-10               | Date: 2026-11-11                 |
| Status: Scheduled              | Status: Scheduled                |
| Independent Seat Inventory S1-S6| Independent Seat Inventory S1-S6 |
+--------------------------------------------------------------------+
```

### 6.2 Timezone Strictness (`America/Toronto`)
* **Canonical Timezone:** All operational schedules, customer-facing departure displays, booking cutoff deadlines, and driver manifest logs are calculated in `America/Toronto` (Eastern Standard Time / Eastern Daylight Time).
* **Daylight Saving Time (DST):** The system relies on PHP's IANA timezone database. Transitions between EST (UTC-5) and EDT (UTC-4) occur automatically without manual schedule recalibration.
* **Database Storage:** Database timestamps (`created_at`, `updated_at`, `departure_time`) are stored in UTC; the application layer formats all presentation times to `America/Toronto`.

---

## 7. Business Rules

* **BR-LOC-01 (Immutability):** Locations, stop sequences, and departure times are hardcoded in seeders/configuration for MVP. Neither passengers nor riders possess privileges to alter, append, or delete them.
* **BR-LOC-02 (Strict Forward Motion):** A booking is only valid if `BoardingStop.stop_sequence < DropoffStop.stop_sequence`. Travel backwards along the sequence is strictly forbidden.
* **BR-LOC-03 (Same-Day Round Trip Independence):** A passenger wishing to travel Montreal → Toronto and return Toronto → Montreal must make two separate bookings across two distinct dated Trip records.
* **BR-LOC-04 (Booking Cutoff Threshold):** `[PROPOSED]` A booking cutoff threshold (proposed default: 30 minutes prior to scheduled departure) is conditional on client confirmation and approval. No cutoff rule is enforced without explicit client direction.
* **BR-LOC-05 (Per-Trip Fare Uniformity):** Any permitted combination of stops on a trip incurs the standard per-trip base fare ($65 CAD regular / $55 CAD promo).

---

## 8. Technical Considerations

* **Database Indexing:** Compound unique index on `(route_id, stop_sequence)` within the `route_stops` table ensures relational ordering integrity.
* **Validation Layer:** Laravel Form Requests validate that `boarding_stop_id` and `dropoff_stop_id` belong to the selected `trip_id` and satisfy `sequence(boarding) < sequence(dropoff)`.

---

## 9. Related Documents
* [`00-project-overview.md`](./00-project-overview.md) — Executive operational summary.
* [`07-database-design.md`](./07-database-design.md) — Schema definitions for `locations`, `routes`, `route_stops`, `trips`.
* [`09-seat-management.md`](./09-seat-management.md) — Detailed segment overlap math based on stop sequences.
* [`10-coupon-and-pricing.md`](./10-coupon-and-pricing.md) — Per-trip fare model.

---

## 10. Assumptions and Pending Decisions

* **Pending Decision (PD-001):** Confirmation from client regarding whether Metro Namur is confirmed as the final drop-off location for Route B in Montreal. Status: **`[PENDING]`**
* **Pending Decision (PD-003):** Confirmation of estimated arrival time in Montreal for Route B (proposed: ~7:15 PM with traffic disclaimer). Status: **`[PROPOSED]`**
