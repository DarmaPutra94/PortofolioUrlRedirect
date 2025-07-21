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

## 🔗 API Routes

| Method | Endpoint                      | Auth Required | Description                          |
|--------|------------------------------|---------------|------------------------------------|
| POST   | `/api/auth/login`             | ❌            | Log in and receive token            |
| POST   | `/api/auth/logout`            | ✅            | Log out (invalidate token)          |
| POST   | `/api/auth/refresh`           | ✅            | Refresh auth token                  |
| POST   | `/api/auth/register`          | ❌            | Register a new user                 |
| GET    | `/api/shorturl`               | ✅            | List user's short URLs              |
| GET    | `/api/shorturl/stats`         | ✅            | List user's short URLs with access count |
| POST   | `/api/shorturl/store`         | ✅            | Create a new short URL              |
| GET    | `/api/shorturl/{short_code}`  | ❌            | Get short URL info                  |
| PUT    | `/api/shorturl/{short_code}`  | ✅            | Update your own short URL           |
| DELETE | `/api/shorturl/{short_code}`  | ✅            | Delete your own short URL           |
| GET    | `/api/shorturl/{short_code}/stats` | ❌      | Get short URL with access count    |
| GET    | `/{short_code}`               | ❌            | Redirect to original URL            |


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
```

---

## 🧪 Testing

✅ The project includes **feature tests** using **PHPUnit** — no unit tests.

### Run all tests:

php artisan test

## 📝 Note

While this project fully meets the requirements of the original challenge,  
I plan to add additional features and improvements in the future.  
Development is ongoing, and new updates will be reflected here as they are completed

## 🚀 Live Demo

A live demo of this URL shortening service is available for testing and exploration.  
Feel free to try out the API endpoints and see the app in action!

Link: https://urlshorter.darma.icu/

> **Note:** This demo is provided for convenience and may be reset periodically.  
> Use it for evaluation purposes only.
