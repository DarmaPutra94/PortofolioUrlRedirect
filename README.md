# 🔗 URL Shortening Service – Laravel API

A secure and simple RESTful API that shortens long URLs, supports user registration and authentication, and tracks access statistics.

> ✅ Built as a portfolio project based on the [roadmap.sh challenge](https://roadmap.sh/projects/url-shortening-service).

---

## 📌 Overview

This project demonstrates my ability to build a real-world API using Laravel. It features:

- 🔐 User authentication with protected routes
- 🔗 URL shortening with unique, random short codes
- 🌐 Public access for redirects and stats
- 📊 Analytics (access count, timestamps)
- 🧪 Feature testing with PHPUnit

---

## ⚙️ Tech Stack

- **Framework:** Laravel 12 (PHP)
- **Authentication:** JWT (via Laravel Sanctum or custom)
- **Database:** MySQL
- **Testing:** PHPUnit
- **API Format:** JSON (RESTful)

---

## 🔐 Authentication Endpoints

| Method | Endpoint             | Auth Required | Description                     |
|--------|----------------------|----------------|---------------------------------|
| POST   | `/api/auth/register` | ❌ No          | Register a new user             |
| POST   | `/api/auth/login`    | ❌ No          | Log in and receive token        |
| POST   | `/api/auth/logout`   | ✅ Yes         | Log out (invalidate token)      |
| POST   | `/api/auth/refresh`  | ✅ Yes         | Refresh authentication token    |

---

## 🔗 URL Management Endpoints

| Method | Endpoint                        | Auth Required | Description                        |
|--------|----------------------------------|----------------|------------------------------------|
| POST   | `/api/shorturl/store`           | ✅ Yes         | Create a new short URL             |
| PUT    | `/api/shorturl/{short_code}`    | ✅ Yes         | Update an existing short URL       |
| DELETE | `/api/shorturl/{short_code}`    | ✅ Yes         | Delete a short URL                 |

---

## 🌍 Public Endpoints

| Method | Endpoint                                | Description                                |
|--------|------------------------------------------|--------------------------------------------|
| GET    | `/api/shorturl/{short_code}`            | Retrieve original URL (JSON)               |
| GET    | `/api/shorturl/{short_code}/stats`      | View public access statistics              |
| GET    | `/{short_code}`                         | Redirect to the original URL (browser use) |

> ⚠️ Note: Only the owner of a short URL can modify or delete it.

---

## 📦 Getting Started

```bash
git clone https://github.com/your-username/url-shortener.git
cd url-shortener
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
