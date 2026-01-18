# API Documentation

Base URL: `http://localhost:8000/api`

## Authentication

All endpoints except `/login` require a Bearer token in the Authorization header.

### Login

```http
POST /api/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@example.com"
  },
  "token": "1|abcdef123456..."
}
```

Use this token in all subsequent requests:
```
Authorization: Bearer 1|abcdef123456...
```

### Get Current User

```http
GET /api/user
Authorization: Bearer {token}
```

### Logout

```http
POST /api/logout
Authorization: Bearer {token}
```

---

## Customers

### Get Statistics

```http
GET /api/customers/stats
Authorization: Bearer {token}
```

**Response:**
```json
{
  "total": 247,
  "lastAdded": "vor 2 Stunden"
}
```

### List Customers

```http
GET /api/customers
Authorization: Bearer {token}
```

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 10)
- `search` - Search in name, first_name, email, or id
- `sort_by` - Column to sort by (default: id)
- `sort_order` - `asc` or `desc` (default: asc)

**Example:**
```http
GET /api/customers?page=1&per_page=10&search=müller&sort_by=name&sort_order=asc
```

**Response:**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "Müller",
      "first_name": "Hans",
      "email": "hans.mueller@example.com",
      "phone": "+49 30 12345678",
      "address": "Hauptstraße 123",
      "postal_code": "10115",
      "city": "Berlin",
      "created_at": "2024-01-15T10:30:00.000000Z",
      "updated_at": "2024-01-15T10:30:00.000000Z"
    }
  ],
  "per_page": 10,
  "total": 247
}
```

### Get Single Customer

```http
GET /api/customers/{id}
Authorization: Bearer {token}
```

### Create Customer

```http
POST /api/customers
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Schmidt",
  "first_name": "Anna",
  "email": "anna.schmidt@example.com",
  "phone": "+49 30 98765432",
  "address": "Berliner Straße 45",
  "postal_code": "10115",
  "city": "Berlin"
}
```

**Required:** `name`, `first_name`, `email`  
**Optional:** `phone`, `address`, `postal_code`, `city`

### Update Customer

```http
PUT /api/customers/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "phone": "+49 30 99999999"
}
```

Only include fields you want to update.

### Delete Customer

```http
DELETE /api/customers/{id}
Authorization: Bearer {token}
```

---

## Error Responses

**401 Unauthorized:**
```json
{
  "message": "Unauthenticated."
}
```

**422 Validation Error:**
```json
{
  "message": "The email has already been taken.",
  "errors": {
    "email": ["The email has already been taken."]
  }
}
```

**404 Not Found:**
```json
{
  "message": "Not found."
}
```