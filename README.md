# Grand Horizon - Full-Stack Luxury Hotel Management System
**PHP (Laravel 12 MVC) | MySQL | HTML5 | CSS3 | JavaScript | XAMPP Server**

A comprehensive, production-ready full-stack web application engineered for luxury hospitality operations. The system features real-time room availability tracking, multi-step online reservation workflows, integrated simulated secure payment transaction handling, automated digital receipt & invoice voucher generation, guest records CRM, and daily facility operations.

---

## 🏨 Project Overview & Core Features

### 1. Room Availability & Inventory Matrix
- **Signature Suites Catalog**: Presidential Penthouse Suite, Executive Ocean View Suite, Royal Deluxe King, Signature Family Penthouse, Grand Classic Double.
- **Physical Room Inventory**: 20+ units across 5 floors with live operational status tracking (`Available`, `Occupied`, `Reserved`, `Cleaning`, `Maintenance`).
- **Real-Time Calendar Availability**: Real-time date interval collision checking preventing double-bookings.
- **Visual Room Matrix**: Color-coded interactive room chips allowing front desk staff to adjust room statuses with 1 click.

### 2. Online Reservation & Booking Workflow
- **Multi-Step Checkout Flow**:
  1. Room category selection, stay date pickers with automatic night calculations.
  2. Guest personal records (Name, Email, Phone, Government ID/Passport, City, Country, Special Requests).
  3. Optional Luxury Add-Ons (Royal Champagne Breakfast, Airport Limousine Chauffeur, Thermal Spa Pass, Guaranteed Late Checkout).
  4. Promo code coupon engine (e.g. `WELCOME10` gives 10% discount on room charges).
  5. Live sticky folio calculating subtotal, add-ons, 12% hospitality tax/VAT, and grand total.

### 3. Secure Payment Transaction Handling & Digital Receipts
- **Multi-Gateway Payment Interface**:
  - **Credit / Debit Cards**: Cardholder name, card number with formatting & Visa/Mastercard detector, expiration date, CVV security code.
  - **Instant UPI / QR Code**: High-resolution dynamic QR code and VPA handle (`grandhorizon@upi`).
  - **Pay at Counter**: Cash or physical terminal upon check-in at front desk.
- **Transaction Processing**:
  - Generates unique reference codes (`TXN-YYYYMMDD-XXXXXX`) and official receipt numbers (`RCPT-YYYY-XXXXX`).
  - Automatically confirms booking status and allocates an available physical room.
- **Digital Printable Receipt & Invoice Voucher**:
  - Executive 5-star hotel invoice format with hotel branding, address, and GSTIN/Tax ID.
  - Itemized financial breakdown (Room charges, services, taxes, amount paid, $0.00 balance due).
  - Verification QR Code and barcode graphic.
  - Clean `@media print` styling for 1-click printing or PDF export.

### 4. Guest Self-Service Portal ("Find My Reservation")
- Guests can retrieve their booking details, room allocation, digital keycard, and invoice voucher anytime using their Booking Reference (`GH-26-XXXX`) and Email address.

### 5. Front Desk & Management Command Center
- **Executive KPI Dashboard**: Occupancy Rate %, Total vs Available vs Occupied Rooms, Today's Check-ins, Today's Check-outs, Today's & Month's Revenue, Pending Housekeeping tasks.
- **Daily Arrivals & Departures**: 1-click Check-In (assigns keycard and marks room occupied) and 1-click Check-Out (frees room and triggers housekeeping sanitization).
- **Front Desk Walk-In Booking**: Direct desk registration interface for walk-ins or phone calls.
- **Housekeeping Board**: Kanban board (Pending, In Progress, Completed) with 1-click "Mark Clean & Inspected" (instantly updates room to Available).
- **Facility Operations & Maintenance**: Daily logs and operational status controls for Infinity Pool, Thermal Spa, Grand Ballroom, Fitness Studio, and Executive Boardroom.
- **Guest CRM**: Directory with lifetime stays count, total spend, and VIP status recognition.
- **Financial Ledger**: Complete audit trail of all transactions filterable by payment method.

---

## 🚀 Setup & Server Information

### Local Environment
- **Web Server**: Apache 2.4 (XAMPP for Windows)
- **Database**: MySQL 8 / MariaDB (XAMPP)
- **PHP Version**: PHP 8.2+
- **Laravel Framework**: Laravel 12 MVC
- **Location on Disk**: `C:\xampp\xampp\htdocs\hotel-management`

### Access URLs
- **Guest Website**: [http://localhost/hotel-management/](http://localhost/hotel-management/) *(or `http://localhost/hotel-management/public`)*
- **Suites & Rates**: [http://localhost/hotel-management/public/rooms](http://localhost/hotel-management/public/rooms)
- **Online Booking**: [http://localhost/hotel-management/public/book](http://localhost/hotel-management/public/book)
- **Track Booking / Receipts**: [http://localhost/hotel-management/public/my-reservation](http://localhost/hotel-management/public/my-reservation)
- **Hotel Facilities**: [http://localhost/hotel-management/public/facilities](http://localhost/hotel-management/public/facilities)
- **Staff Management Portal**: [http://localhost/hotel-management/public/admin/login](http://localhost/hotel-management/public/admin/login)

---

## 🔑 Default Staff Login Credentials

| Role | Email Address | Password | Permissions |
| :--- | :--- | :--- | :--- |
| **Hotel Administrator / General Manager** | `admin@hotel.com` | `password123` | Full Administrative Access |
| **Front Desk Receptionist** | `reception@hotel.com` | `password123` | Front Desk, Check-In/Out, Folios |
| **Housekeeping Supervisor** | `housekeeping@hotel.com` | `password123` | Housekeeping Board & Room Status |

*(Quick-fill buttons are integrated directly on the login page for convenience).*

---

## 💾 Database Schema (`hotel_management_db`)

1. `users`: Staff credentials, roles (`admin`, `receptionist`, `housekeeper`), contact info.
2. `room_types`: Suite categories, base prices, capacities, bed types, sqft, galleries, amenities JSON.
3. `rooms`: Physical units, floor levels, statuses (`available`, `occupied`, `reserved`, `cleaning`, `maintenance`), housekeeping state (`clean`, `inspecting`, `dirty`).
4. `guests`: Profiles, names, emails, phones, IDs, locations, VIP flags.
5. `reservations`: References (`GH-26-XXXX`), dates, nights, guests, room rates, services charges, taxes, discounts, totals, booking status, keycards.
6. `reservation_services`: Selected add-on amenities (Breakfast, Limousine, Spa).
7. `payments`: Transactions (`TXN-XXXX`), receipt numbers (`RCPT-XXXX`), methods (`card`, `upi`, `cash`), amounts, gateway references, timestamps.
8. `housekeeping_tasks`: Cleaning priorities, task types, assigned staff, completion logs.
9. `facility_operations`: Pool, Spa, Ballroom, Gym status, daily maintenance notes.
10. `facility_bookings`: Guest reservations for resort amenities.
