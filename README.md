# Slotsmart — Automated Hybrid Class Scheduling System

PHP port of the original single-file Slotsmart prototype, with:
- ✅ MySQL persistence
- ✅ Bcrypt password hashing
- ✅ CSRF protection on every POST form
- ✅ Email verification (link is written to `verification_debug.log` for dev)
- ✅ Login attempt lockout (5 tries → 15 min lock)
- ✅ Session regeneration & httponly cookies
- ✅ Audit log table
- ✅ Role-based views (admin / faculty)

## Requirements
- PHP 8.0+ (tested on 8.2)
- MySQL 5.7+ / MariaDB 10.3+
- XAMPP / WAMP / LAMP (or `php -S localhost:8000 -t public`)

## Setup

### 1. Create the database
```sql
mysql -u root -p < database.sql