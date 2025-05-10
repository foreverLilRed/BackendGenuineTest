
# 📦 Laravel API - Technical Backend Test

This is a RESTful API built with Laravel to manage products and categories, designed to support Dialogflow integration. It allows a chatbot to request the number of available products in a specific category.



## 🚀 Technologies Used

- PHP 8.2+
- Laravel 12
- MySQL or SQLite (configurable)
- Composer


## Installation

### 1. Clone the repository

```bash
  git clone https://github.com/foreverLilRed/BackendGenuineTest.git
  cd BackendGenuineTest
```

### 2. Install dependencies

```bash
  composer install
```

### 3. Create your .env file

```bash
  cp .env.example .env
```
⚠️ Set up your database credentials in the .env file

```bash
  DB_DATABASE=your_database
  DB_USERNAME=your_username
  DB_PASSWORD=your_password
```

### 4. Generate application key

```bash
  php artisan key:generate
```

### 5. Run migrations and seeders

```bash
  php artisan migrate --seed
```

### 6. Start the development server

```bash
  php artisan serve
```
## API Reference

#### Get categories

```http
GET /api/category
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | Optional. Search by category name (max 255)|
| `description` | `string` | Optional. Search by category name (max 255)|
| `per_page` | `integer` | Optional. Items per page (default 15, max 100)|

#### Get a specific category

```http
  GET /api/category/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of the category |

#### Create a category

```http
  POST /api/category
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Required**. Category name (min 1, max 255, unique) |
| `description`      | `string` | Optional. Category description (max 500) |

#### Update a category

```http
   PUT or PATCH /api/category/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of the category |
| `name`      | `string` | Optional. Category name (min 1, max 255, unique) |
| `description`      | `string` | Optional. Category description (max 500) |

#### Delete a category

```http
   DELETE /api/category/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of the category |

#### Get products

```http
GET /api/product
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | Optional. Search by category name (max 255)|
| `description` | `string` | Optional. Search by category name (max 1000)|
| `min_quantity` | `integer` | Optional. Minimum quantity (min 0)|
| `max_quantity` | `integer` | Optional. Maximum quantity (min 0)|
| `category_name` | `string` | Optional. Filter by category name (max 255)|
| `category_id` | `integer` | Optional. Filter by category ID|
| `per_page` | `integer` | Optional. Items per page (default 15, max 100)|

#### Get a specific product

```http
  GET /api/product/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of the product |

#### Create a product

```http
  POST /api/product
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Required**. Category name (min 1, max 255, unique) |
| `description`      | `string` | Optional. Category description (max 1000) |
| `quantity`      | `integer` | Optional. Product quantity (min 0) |
| `category_id`      | `integer` | **Required**. Category ID |

#### Update a product

```http
   PUT or PATCH /api/product/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | Optional. Id of the product |
| `name`      | `string` | Optional. Product name (min 1, max 255, unique) |
| `description`      | `string` | Optional. Product quantity (min 1) |
| `category_id`      | `integer` | Optional. Product ID |

#### Delete a product

```http
   DELETE /api/product/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of the product |



# Dialogflow Integration

This API provides a single webhook endpoint for handling Dialogflow intent requests.


#### Endpoint

```http
   POST /api/dialogflow-webhook
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of the product |

##  Supported Intents

#### 1. `CountProductsByCategory`

**Description:**  
Returns the total quantity of products available in a specific category.

**Expected Parameters:**

| Parameter       | Type     | Required | Description                                   |
|-----------------|----------|----------|-----------------------------------------------|
| `category_name` | `string` | ✅       | Name of the category (case-insensitive match) |

**Example Response:**

```
There are 42 products available in the 'Electronics' category.
```

---

#### 2. `QueryEntity`

**Description:**  
Returns a list of either categories or products based on the requested entity type and optional filters.

**Expected Parameters:**

| Parameter                | Type     | Required | Description                                                     |
|--------------------------|----------|----------|-----------------------------------------------------------------|
| `EntityType`             | `string` | ✅       | Determines the type of entity to search: `"category"` or `"product"` |
| `product_name`           | `string` | ❌       | Optional. Filters by product or category name                   |
| `product_description`    | `string` | ❌       | Optional. Filters by product or category description            |

**Behavior:**
- If `EntityType` is `"category"`, it will return a list of matching categories.
- If `EntityType` is `"product"`, it will return a list of matching products.
- If no matches are found, it responds accordingly.
- If `EntityType` is invalid or missing, it will return a fallback message.

**Example Request Payload (Dialogflow):**

```json
{
  "queryResult": {
    "intent": {
      "displayName": "QueryEntity"
    },
    "parameters": {
      "EntityType": "product",
      "product_name": "laptop",
      "product_description": ""
    }
  }
}
```

**Example Response:**

```
The available products are: Laptop Pro, Laptop Air, Gaming Laptop.
```

**Alternative Response:**

```
I did not understand if you meant categories or products.
```