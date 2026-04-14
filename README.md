<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

تمام 👌 ده **README احترافي جاهز** لمشروعك `Inventory_task` — تقدر تحطه مباشرة في GitHub ويبان كأنه مشروع Production / Hiring-ready 💼🔥

---

# 📦 Inventory Task – Product Inventory Microservice

A **Laravel-based Product Inventory Microservice** built using **Clean Architecture principles**, **Repository Pattern**, **Service Layer**, and **Redis caching**.

The system provides a scalable RESTful API for managing products and stock operations.

---

# 🚀 Tech Stack

* Laravel 10/11
* PHP 8.1+
* PostgreSQL
* Redis
* Docker
* PHPUnit (Feature Testing)

---

# 🧱 Architecture Overview

The project follows a **Layered Architecture**:

```
Client
 ↓
Controller (API Layer)
 ↓
Service Layer (Business Logic)
 ↓
Repository Layer (Data Access)
 ↓
PostgreSQL
 ↑
Redis Cache Layer
```

### Key Principles:

* Separation of concerns
* Clean architecture
* Scalable microservice design
* Testable components

---

# 📦 Features

## 🧾 Product Management

* Create product
* Update product
* Get all products (pagination)
* Get single product
* Soft delete product

## 📊 Stock Management

* Increment stock
* Decrement stock
* Prevent negative stock values

## ⚠️ Low Stock Monitoring

* Retrieve products where:

  ```
  stock_quantity < low_stock_threshold
  ```

---

# 📡 API Endpoints

## Products

| Method | Endpoint             | Description                  |
| ------ | -------------------- | ---------------------------- |
| GET    | `/api/products`      | Get all products (paginated) |
| GET    | `/api/products/{id}` | Get single product           |
| POST   | `/api/products`      | Create product               |
| PUT    | `/api/products/{id}` | Update product               |
| DELETE | `/api/products/{id}` | Soft delete product          |

---

## Stock

| Method | Endpoint                   | Description                        |
| ------ | -------------------------- | ---------------------------------- |
| POST   | `/api/products/{id}/stock` | Adjust stock (increment/decrement) |

---

## Low Stock

| Method | Endpoint                       | Description            |
| ------ | ------------------------------ | ---------------------- |
| GET    | `/api/products/low-stock/list` | Get low stock products |

---

# ⚡ Caching Strategy (Redis)

Redis is used to improve performance and reduce database load.

### Cached Data:

* Product listing (paginated)
* Single product details
* Low stock products

### Cache Invalidation occurs when:

* Product is created
* Product is updated
* Product is deleted
* Stock is adjusted

---

# 🧠 Design Patterns Used

* Repository Pattern
* Service Layer Pattern
* Dependency Injection
* Factory Pattern (for testing/seeding)

---

# 🗄️ Database Schema

### Products Table

* id (UUID)
* sku (unique)
* name
* description (nullable)
* price (decimal)
* stock_quantity (integer)
* low_stock_threshold (default: 10)
* status (active / inactive / discontinued)
* timestamps
* soft deletes

---

# 🧪 Testing

Feature tests implemented for:

* Create product
* Update product
* Delete product
* Adjust stock
* Get low stock products

Run tests:

```bash
php artisan test
```

---

# 🐳 Docker Setup

The project includes Docker support for easy setup.

### Services:

* Laravel App
* PostgreSQL
* Redis

Run project:

```bash
docker-compose up --build
```

---

# ⚙️ Installation

```bash
git clone https://github.com/kerolsshafik/Inventory_task.git
cd Inventory_task

composer install
cp .env.example .env

php artisan key:generate
php artisan migrate

php artisan serve
```

---

# 🔐 Validation & Error Handling

* Form Request validation used for all inputs
* Centralized API response structure
* Global exception handling for clean error responses

---

# 📦 API Response Format

All responses follow a consistent structure:

```json
{
  "success": true,
  "data": {},
  "meta": {
    "pagination": {}
  }
}
```

---

# 🚀 Performance Improvements

* Redis caching for fast responses
* Database indexing on frequently queried fields
* Pagination for large datasets
* Soft deletes to preserve data integrity

---

# 📌 Future Improvements

* JWT Authentication / Laravel Sanctum
* Event-driven architecture (Low stock alerts)
* Queue system for background jobs
* Swagger API documentation
* CI/CD pipeline (GitHub Actions)

---

# 👨‍💻 Author

**Kerols Shafik**
Backend Developer (PHP / Laravel)

---

# ⭐ Project Goal

This project demonstrates:

* Clean backend architecture
* Scalable microservice design
* Professional Laravel practices
* Production-ready API development

---

# 🔥 لو عايز Upgrade أقوى

أقدر أعملك نسخة تانية فيها:

* badges (tests, coverage, laravel version)
* Swagger UI integration
* GitHub Actions CI pipeline
* Advanced diagrams (architecture flow image)

بس قولّي:
👉 "Upgrade README pro level"

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
