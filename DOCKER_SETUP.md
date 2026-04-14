# Docker Setup Guide - Inventory API

This guide helps you get the Inventory API running with Docker.

## Prerequisites

- Docker Desktop (or Docker Engine + Docker Compose)
- Git

## Quick Start

### 1. Clone and Setup

```bash
cd inventory
cp .env.example .env
```

### 2. Build and Run

```bash
docker-compose build
docker-compose up -d
```

### 3. Initialize Database

```bash
# Run migrations
docker-compose exec app php artisan migrate

# Seed database (optional)
docker-compose exec app php artisan db:seed
```

### 4. Access Application

- **API**: http://localhost:8000
- **Nginx**: http://localhost:80
- **Database**: localhost:5432
- **Redis**: localhost:6379

---

## Services

### App (Laravel)

- **Container**: `inventory_app`
- **Port**: 8000
- **Volumes**: Project root mounted at `/var/www`

### Database (PostgreSQL)

- **Container**: `inventory_db`
- **Port**: 5432
- **Credentials**: postgres/kerols12345
- **Database**: inventory

### Cache (Redis)

- **Container**: `inventory_redis`
- **Port**: 6379

### Web Server (Nginx)

- **Container**: `inventory_nginx`
- **Port**: 80

---

## Common Commands

### Run Migrations

```bash
docker-compose exec app php artisan migrate
```

### Run Tests

```bash
docker-compose exec app php artisan test
```

### Run Specific Test File

```bash
docker-compose exec app php артisan test tests/Feature/Product/ProductTest.php
```

### Access Container Shell

```bash
docker-compose exec app bash
```

### View Logs

```bash
docker-compose logs -f app
```

### Clear Cache

```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
```

### Create Database Backup

```bash
docker-compose exec db pg_dump -U postgres inventory > backup.sql
```

### Restore Database from Backup

```bash
cat backup.sql | docker-compose exec -T db psql -U postgres
```

---

## Useful Artisan Commands

```bash
# List all routes
docker-compose exec app php artisan route:list

# Clear all caches
docker-compose exec app php artisan optimize:clear

# Create new controller
docker-compose exec app php artisan make:controller Controller/ControllerName

# Create migration
docker-compose exec app php artisan make:migration create_table_name

# Tinker (Laravel REPL)
docker-compose exec app php artisan tinker
```

---

## Troubleshooting

### Port Already in Use

If you get "address already in use", change the port in `docker-compose.yml`:

```yaml
ports:
    - "8001:8000" # Use 8001 instead of 8000
```

### Database Connection Issues

Check environment variables in `docker-compose.yml` match `.env`.

### Permission Issues

```bash
docker-compose exec app chown -R www-data:www-data /var/www
```

### Rebuild Images

```bash
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

---

## Stop and Remove

### Stop Services

```bash
docker-compose stop
```

### Remove Containers

```bash
docker-compose down
```

### Remove Volumes (Data Loss!)

```bash
docker-compose down -v
```

---

## Production Notes

For production deployment:

1. Set `APP_ENV=production` in `.env`
2. Use a proper `.env` file (not `.env.example`)
3. Set strong database passwords
4. Enable SSL/TLS in Nginx
5. Use environment-specific docker-compose files

---

## Support

For issues, check:

- Docker logs: `docker-compose logs`
- Container shell: `docker-compose exec app bash`
- PHP errors: Check `storage/logs/`
