# Webhook Delivery Service

A webhook delivery service built with Laravel.

## Features

- Accept webhook events
- Store events in SQLite
- Deliver events asynchronously using Laravel Jobs
- Retry failed deliveries
- Track delivery status
- REST API

---

## Tech Stack

- PHP 8.x
- Laravel 12
- SQLite

---

## Installation

Clone repository

```bash
git clone <repository-url>
```

Go to project

```bash
cd backend
```

Install dependencies

```bash
composer install
```

Copy environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Create SQLite database

```bash
touch database/database.sqlite
```

Run migrations

```bash
php artisan migrate
```

Start server

```bash
php artisan serve
```

---

## API

### Create Event

POST

```
/api/events
```

Example

```json
{
    "customerId": "123",
    "endpoint": "https://example.com/webhook",
    "payload": {
        "orderId": 1
    }
}
```

---

### Get Event Status

GET

```
/api/events/{id}
```

Example response

```json
{
    "id": 1,
    "status": "delivered",
    "attempts": 1,
    "last_error": null
}
```

---

## Project Structure

```
app/
Controllers/
Jobs/
Models/
Services/
```
