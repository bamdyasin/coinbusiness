# CoinStore.bd - Course & Digital Asset Platform

A professional web application for selling digital assets (TikTok Top-Ups, Views, Likes) and course memberships with a built-in referral commission system.

## 🚀 Key Features

### 1. User Dashboard
- **Modern UI:** Glassmorphism-inspired dark theme optimized for all devices.
- **Dynamic Stats:** Real-time balance and referral tracking.
- **Interactive Payment:** Selectable payment methods (bKash, Nagad, Rocket) with auto-updating numbers and easy "Copy" buttons.
- **Locked Content:** Premium training videos and tools are automatically locked for unpaid users.
- **Mobile Optimized:** Floating bottom navigation bar for a native app-like experience.

### 2. Admin Panel
- **Comprehensive Manager:** Centralized control for users, payments, and system security.
- **Premium Request Handler:** Verify and approve membership payments with automated commission distribution.
- **OTP Manager:** Monitor and manually verify/delete user OTP requests to resolve synchronization issues.
- **Dynamic Settings:** Change payment numbers, account types, and support links directly from the admin UI without touching code.
- **User Management:** Search, delete, or manually update user balances.

### 3. Business Logic
- **Referral System:** Automated link tracking and 100 Taka commission on premium upgrades.
- **Security:** Session-based authentication, hashed passwords, and synchronized timezone (Asia/Dhaka) for OTP reliability.

## 🛠 Tech Stack
- **Backend:** PHP 8.x
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, Bootstrap 5.3, Bootstrap Icons
- **Fonts:** Hind Siliguri (Bengali Support), Inter

## ⚙️ Installation

1.  **Clone/Upload:** Upload the project files to your server (XAMPP/Cpanel).
2.  **Database:** 
    - Create a database named `coinstorebd`.
    - Import `database/schema.sql`.
3.  **Configure:** Update `includes/db.php` with your database credentials.
4.  **Migration:** Visit `yoursite.com/migrate.php` to initialize default settings and admin credentials.
5.  **Admin Login:**
    - URL: `/admin/login.php`
    - User: `admin`
    - Pass: `admin123` (Change this immediately in the database).

## 📂 Project Structure
- `/admin`: Management modules (Dashboard, Users, Payments, OTPs, Settings).
- `/user`: Customer experience (Registration, Login, Dashboard, Payment).
- `/shop`: Digital product catalogs.
- `/referral`: Affiliate tracking logic.
- `/includes`: Core DB connection, global configurations, and root UI components (Header/Footer).

---
Developed with ❤️ for CoinStore.bd
