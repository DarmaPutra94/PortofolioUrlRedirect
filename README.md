# 🔗 URL Shortening Service – Laravel API

A secure and RESTful Laravel API for shortening long URLs, managing them via authentication, and tracking access stats.

> ✅ Built as a portfolio project inspired by the [roadmap.sh challenge](https://roadmap.sh/projects/url-shortening-service).

---

## 📌 Overview

This project demonstrates my backend development skills using Laravel. It includes:

- 🔐 Authenticated URL management
- 🔗 Random, unique shortcode generation
- 🌐 Public access to redirects and stats
- 📊 Basic analytics (access count, timestamps)
- 🧪 **Feature testing** with **PHPUnit** (no unit tests)

---

## ⚙️ Tech Stack

- **Framework:** Laravel 12 (PHP)
- **Database:** MySQL
- **Authentication:** JWT (Laravel Sanctum-style flow)
- **Testing:** PHPUnit (Feature tests only)
- **API Format:** JSON

---

## 🔐 Authentication Endpoints

| Method | Endpoint             | Auth Required | Description                     |
|--------|----------------------|---------------|---------------------------------|
| POST   | `/api/auth/register` | ❌ No         | Register a new user             |
| POST   | `/api/auth/login`    | ❌ No         | Log in and receive token        |
| POST   | `/api/auth/logout`   | ✅ Yes        | Log out (invalidate token)      |
| POST   | `/api/auth/refresh`  | ✅ Yes        | Refresh auth token              |

---

## 🔗 Short URL Endpoints

| Method | Endpoint                      | Auth Required | Description                  |
|--------|------------------------------|---------------|------------------------------|
| POST   | `/api/shorturl/store`         | ✅ Yes        | Create a short URL           |
| PUT    | `/api/shorturl/{short_code}`  | ✅ Yes        | Update your own short URL    |
| DELETE | `/api/shorturl/{short_code}`  | ✅ Yes        | Delete your own short URL    |

---

## 🌍 Public Access Endpoints

| Method | Endpoint                         | Description                            |
|--------|---------------------------------|--------------------------------------|
| GET    | `/api/shorturl/{short_code}`    | Retrieve original URL (JSON)          |
| GET    | `/api/shorturl/{short_code}/stats` | View public stats (access count, etc.) |
| GET    | `/{short_code}`                 | Redirect to original URL              |

> 🛡️ Only authenticated users can manage their own short URLs.

---

## 📦 Getting Started

git clone https://github.com/your-username/url-shortener.git
cd url-shortener
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

---

## 🧪 Testing

✅ The project includes **feature tests** using **PHPUnit** — no unit tests.

### Run all tests:

php artisan test
