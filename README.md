# 📋 Naira Chain Task API

> A modern Laravel-powered REST API for seamless authentication and invoice management

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## ✨ Key Features

-   🔐 **Secure Authentication** - Powered by Laravel Sanctum, registration, login, and logout flow
-   📄 **Invoice CRUD Operations** - Full invoice lifecycle management
-   🎯 **RESTful Design** - Clean, consistent API structure

---

## 🏗️ Installation & Setup

### System Requirements

| Component | Version |
| --------- | ------- |
| PHP       | 8.2+    |
| Laravel   | 12.x    |
| Composer  | Latest  |

### Quick Start

```bash
# 1. Clone the repository
git clone https://github.com/devMuhammad05/naira-chain-task.git
cd naira-chain-task

# 2. Install PHP dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Database configuration
# Update your .env file with database credentials:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# 5. Run database migrations
php artisan migrate

# 6. Start the development server
php artisan serve
```

🎉 **Your API is now running at:** `http://127.0.0.1:8000/api/v1`

---

## 🔐 Authentication System

This API implements **Laravel Sanctum** for secure token-based authentication.

### Authentication Flow

1. Register or login to receive an access token
2. Include the token in the `Authorization` header for protected routes
3. Use the logout endpoint to invalidate tokens

### Header Format

```http
Authorization: Bearer {your_access_token}
```

---

## 📚 API Reference

### Base URL

```
http://127.0.0.1:8000/api/v1
```

## 🔑 Authentication Endpoints

### Register User

Creates a new user account and returns an access token.

**Endpoint:** `POST /auth/register`

**Request Body:**

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "securePassword123"
}
```

**Validation Rules:**

-   `name` - Required, string, max 255 characters
-   `email` - Required, valid email, max 255 characters, unique
-   `password` - Required, string, minimum 6 characters

**Success Response (201):**

```json
{
    "message": "Registration successful",
    "data": {
        "token": "1|abc123def456ghi789jkl012mno345pqr678stu901vwx234yz",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "email_verified_at": null,
            "created_at": "2025-09-26T10:30:00.000000Z",
            "updated_at": "2025-09-26T10:30:00.000000Z"
        }
    }
}
```

---

### User Login

Authenticates existing user credentials and returns an access token.

**Endpoint:** `POST /auth/login`

**Request Body:**

```json
{
    "email": "john@example.com",
    "password": "securePassword123"
}
```

**Validation Rules:**

-   `email` - Required, valid email format
-   `password` - Required, string

**Success Response (200):**

```json
{
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "email_verified_at": null,
            "created_at": "2025-09-26T10:30:00.000000Z",
            "updated_at": "2025-09-26T10:30:00.000000Z"
        },
        "token": "2|xyz789abc123def456ghi789jkl012mno345pqr678"
    }
}
```

**Error Response (401):**

```json
{
    "message": "Email or password incorrect"
}
```

---

### User Logout

Revokes the current user's access token.

**Endpoint:** `POST /logout`  
**Authentication:** Required

**Success Response (200):**

```json
{
    "message": "Logout successful"
}
```

---

## 📄 Invoice Management

> All invoice endpoints require authentication

### List All Invoices

Retrieves all invoices for the authenticated user, ordered by latest first.

**Endpoint:** `GET /invoices`  
**Authentication:** Required

**Success Response (200):**

```json
{
    "message": "Invoices retrieved successfully",
    "data": [
        {
            "id": 1,
            "invoice_number": "INV-2025-001",
            "description": "Web development services for Q1 2025",
            "billing_name": "Jane Smith",
            "billing_email": "jane.smith@company.com",
            "billing_address": "456 Business Ave, Suite 200, New York, NY 10001",
            "total_amount": "7500.00",
            "issue_date": "2025-09-26",
            "due_date": "2025-10-26",
            "status": "Pending",
            "user_id": 1,
            "created_at": "2025-09-26T10:30:00.000000Z",
            "updated_at": "2025-09-26T10:30:00.000000Z"
        }
    ]
}
```

---

### Create New Invoice

Creates a new invoice for the authenticated user.

**Endpoint:** `POST /invoices`  
**Authentication:** Required

**Request Body:**

```json
{
    "invoice_number": "INV-2025-002",
    "description": "Mobile app development and UI/UX design services",
    "billing_name": "Tech Solutions Ltd",
    "billing_email": "billing@techsolutions.com",
    "billing_address": "789 Innovation Drive, Silicon Valley, CA 94043",
    "total_amount": 12500.0,
    "issue_date": "2025-09-26",
    "due_date": "2025-11-26",
    "status": "Draft"
}
```

**Success Response (201):**

```json
{
    "message": "Invoice created successfully",
    "data": {
        "id": 2,
        "invoice_number": "INV-2025-002",
        "description": "Mobile app development and UI/UX design services",
        "billing_name": "Tech Solutions Ltd",
        "billing_email": "billing@techsolutions.com",
        "billing_address": "789 Innovation Drive, Silicon Valley, CA 94043",
        "total_amount": "12500.00",
        "issue_date": "2025-09-26",
        "due_date": "2025-11-26",
        "status": "Draft",
        "user_id": 1,
        "created_at": "2025-09-26T11:15:00.000000Z",
        "updated_at": "2025-09-26T11:15:00.000000Z"
    }
}
```

---

### Get Single Invoice

Retrieves a specific invoice by ID.

**Endpoint:** `GET /invoices/{id}`  
**Authentication:** Required

**Success Response (200):**

```json
{
    "message": "Invoice retrieved successfully",
    "data": {
        "id": 1,
        "invoice_number": "INV-2025-001",
        "description": "Web development services for Q1 2025",
        "billing_name": "Jane Smith",
        "billing_email": "jane.smith@company.com",
        "billing_address": "456 Business Ave, Suite 200, New York, NY 10001",
        "total_amount": "7500.00",
        "issue_date": "2025-09-26",
        "due_date": "2025-10-26",
        "status": "Pending",
        "user_id": 1,
        "created_at": "2025-09-26T10:30:00.000000Z",
        "updated_at": "2025-09-26T10:30:00.000000Z"
    }
}
```

**Error Response (403) - Unauthorized Access:**

```json
{
    "message": "Unauthorized access to invoice"
}
```

**Error Response (404) - Not Found:**

```json
{
    "message": "Invoice not found"
}
```

---

### Update Invoice

Updates an existing invoice. Supports both full updates (PUT) and partial updates (PATCH).

**Endpoint:** `PUT|PATCH /invoices/{id}`  
**Authentication:** Required

**Request Body (Partial Update):**

```json
{
    "status": "Paid",
    "total_amount": 8000.0
}
```

**Success Response (200):**

```json
{
    "message": "Invoice updated successfully",
    "data": {
        "id": 1,
        "invoice_number": "INV-2025-001",
        "description": "Web development services for Q1 2025",
        "billing_name": "Jane Smith",
        "billing_email": "jane.smith@company.com",
        "billing_address": "456 Business Ave, Suite 200, New York, NY 10001",
        "total_amount": "8000.00",
        "issue_date": "2025-09-26",
        "due_date": "2025-10-26",
        "status": "Paid",
        "user_id": 1,
        "created_at": "2025-09-26T10:30:00.000000Z",
        "updated_at": "2025-09-26T14:20:00.000000Z"
    }
}
```

**Error Response (403):**

```json
{
    "message": "Unauthorized access to invoice"
}
```

---

### Delete Invoice

Permanently deletes an invoice.

**Endpoint:** `DELETE /invoices/{id}`  
**Authentication:** Required

**Success Response (204) - No Content:**

```json

```

**Error Response (403):**

```json
{
    "message": "Unauthorized access to invoice"
}
```

---

## 📊 Invoice Status Values

| Status      | Description                       |
| ----------- | --------------------------------- |
| `Draft`     | Invoice created but not yet sent  |
| `Pending`   | Invoice sent and awaiting payment |
| `Paid`      | Invoice has been paid in full     |
| `Overdue`   | Invoice past due date and unpaid  |
| `Cancelled` | Invoice has been cancelled        |

---

## 🛡️ Security Features

-   **Token-based Authentication** - Secure API access with Laravel Sanctum
-   **Input Validation** - Comprehensive request validation using Form Requests
-   **Authorization Checks** - Users can only access their own invoices
-   **Password Hashing** - Secure password storage with bcrypt
-   **Model Route Binding** - Laravel's implicit model binding for cleaner code

---

## 🚨 Error Handling

The API returns consistent error responses with appropriate HTTP status codes:

### Validation Error (422)

```json
{
    "message": "The invoice number field is required. (and 4 more errors)",
    "errors": {
        "invoice_number": ["The invoice number field is required."],
        "billing_name": ["The billing name field is required."],
        "total_amount": ["The total amount field is required."],
        "issue_date": ["The issue date field is required."],
        "status": ["The status field is required."]
    }
}
```

### Unauthorized Access (401)

```json
{
    "message": "Unauthenticated."
}
```

### Forbidden Access (403)

```json
{
    "message": "Unauthorized access to invoice"
}
```

### Resource Not Found (404)

```json
{
    "message": "Invoice not found"
}
```

### Server Error (500)

```json
{
    "message": "Internal server error occurred."
}
```

---

## 📋 Testing the API

### Using cURL

**Register a new user:**

```bash
curl -X POST http://127.0.0.1:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123"
  }'
```

**Login:**

```bash
curl -X POST http://127.0.0.1:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

**Create an invoice:**

```bash
curl -X POST http://127.0.0.1:8000/api/v1/invoices \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "invoice_number": "INV-TEST-001",
    "description": "Test invoice",
    "billing_name": "Test Client",
    "billing_email": "client@test.com",
    "billing_address": "123 Test Street",
    "total_amount": 1000,
    "issue_date": "2025-09-26",
    "due_date": "2025-10-26",
    "status": "Draft"
  }'
```

**Get all invoices:**

```bash
curl -X GET http://127.0.0.1:8000/api/v1/invoices \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Update an invoice:**

```bash
curl -X PATCH http://127.0.0.1:8000/api/v1/invoices/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "status": "Paid"
  }'
```

**Delete an invoice:**

```bash
curl -X DELETE http://127.0.0.1:8000/api/v1/invoices/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Using Postman

Import the API endpoints into Postman or use tools like **Insomnia** for a user-friendly testing experience.

## 📝 Notes

-   Password minimum length is **6 characters** (as defined in AuthController validation)
-   Invoice deletion returns **HTTP 204 No Content** (empty response body)
-   All invoice operations include **ownership verification** to ensure users can only access their own invoices
-   The API uses **latest()** ordering for invoice listings (newest first)
-   **Form Request classes** are used for validation (referenced in InvoiceController)

---
