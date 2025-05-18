# Laravel Scheduled Notifications System

This project is a professional notification and OTP delivery system built with Laravel. It supports scheduled message dispatch, OTP authentication, queue processing, and clean service/repository architecture.

---

## 🔧 Features

### 🔐 Authentication
- OTP-based authentication (One-Time Password)
- API authentication using Laravel Sanctum

### 🧱 Architecture
- Clean, layered architecture using the **Repository** and **Service** patterns
- Repositories handle database logic
- Services manage business logic
- JSON response macro for consistent API responses
- Separation of concerns for maintainability and testability

### 📬 Notifications
- Send SMS via Melipayamak API
- Save messages in `notifications` table
- Schedule messages using `scheduled_notifications` table

### ⏰ Scheduled Notifications
- Add messages to be sent at a specific future time
- Artisan command for dispatching:
  ```bash
  php artisan notifications:send-scheduled-notifications

### Requirements
- PHP: 8.2 or higher.
- Laravel: 12.x.
- Database: MySQL.
- Composer: Dependency management.
- Melipayamak API Key: For SMS dispatch.

🧑‍💻 Author
  - Developer: Younes
  - Framework: Laravel
  - SMS Provider: Melipayamak
