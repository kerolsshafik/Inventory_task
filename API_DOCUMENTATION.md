# Inventory API Documentation

## Base URL

```
http://127.0.0.1:8000/api
```

---

## Endpoints

### 1. List Products (Paginated)

- **GET** `/products?per_page=10`
- **Description:** Returns paginated list of products.
- **Query Params:**
    - `per_page` (optional, default: 10)
- **Response:**
    - `success`, `data` (array), `meta.pagination`

### 2. Show Product

- **GET** `/products/{id}`
- **Description:** Get a single product by ID.
- **Response:**
    - `success`, `data` (object)

### 3. Create Product

- **POST** `/products`
- **Body:**

```json
{
    "sku": "SKU123",
    "name": "Sample Product",
    "description": "Description here",
    "price": 10.5,
    "stock_quantity": 100,
    "low_stock_threshold": 10,
    "status": "active"
}
```

- **Response:**
    - `success`, `data` (object)

### 4. Update Product

- **PUT** `/products/{id}`
- **Body:** (any updatable fields)

```json
{
    "name": "Updated Product",
    "price": 12.0
}
```

- **Response:**
    - `success`, `data` (object)

### 5. Delete Product

- **DELETE** `/products/{id}`
- **Response:**
    - `success`, `data.deleted` (boolean)

### 6. Adjust Product Stock

- **POST** `/products/stock`
- **Body:**

```json
{
    "id": 1,
    "quantity": 5,
    "type": "increment" // or "decrement"
}
```

- **Response:**
    - `success`, `data` (object)

### 7. List Low Stock Products

- **GET** `/products/low-stock/list`
- **Response:**
    - `success`, `data` (array)

---

## Validation Rules

- See `StoreProductRequest`, `UpdateProductRequest`, and `StockProductRequest` for detailed validation.

## Response Format

All responses use the `ApiResponse` trait for consistency:

- `success`: boolean
- `data`: main payload
- `meta`: (for paginated responses)
- `message`/`errors`: for error responses

---

## Postman Collection

A ready-to-use Postman collection is provided in `postman_collection.json`.

---

## Notes

- All endpoints are throttled (60 requests/minute).
- All product IDs are UUIDs.
- Error responses use standard format with `success: false` and `message`.

---

## Sample Usage

- Import the Postman collection and set `{{url}}` to your API base URL.
- Use the provided endpoints for CRUD and stock management operations.
