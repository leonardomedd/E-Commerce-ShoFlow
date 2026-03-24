# ShopFlow API - Request Examples

Este arquivo contém exemplos de requests para todos os endpoints da API.

## 🔑 Base URL
```
http://localhost:8000/api
```

## 🔐 Autenticação

Todos os endpoints que requerem autenticação devem incluir:
```
Authorization: Bearer {token}
Content-Type: application/json
```

---

## 📋 Exemplos de Requests

### 1. REGISTRAR NOVO USUÁRIO

```http
POST /api/register
Content-Type: application/json

{
  "name": "João Silva",
  "email": "joao@example.com",
  "password": "senha123",
  "password_confirmation": "senha123"
}
```

**Resposta (201):**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 11,
    "name": "João Silva",
    "email": "joao@example.com",
    "role": "customer"
  },
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

---

### 2. LOGIN

```http
POST /api/login
Content-Type: application/json

{
  "email": "admin@shopflow.com",
  "password": "password"
}
```

**Resposta (200):**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "Admin ShopFlow",
    "email": "admin@shopflow.com",
    "role": "admin"
  },
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

---

### 3. OBTER DADOS DO USUÁRIO ATUAL

```http
GET /api/me
Authorization: Bearer {token}
```

**Resposta (200):**
```json
{
  "user": {
    "id": 11,
    "name": "João Silva",
    "email": "joao@example.com",
    "role": "customer"
  }
}
```

---

### 4. LOGOUT

```http
POST /api/logout
Authorization: Bearer {token}
```

**Resposta (200):**
```json
{
  "message": "Logged out successfully"
}
```

---

### 5. LISTAR CATEGORIAS

```http
GET /api/categories
```

**Resposta (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Eletrônicos",
      "slug": "eletronicos",
      "products_count": 6,
      "created_at": "2026-03-21T21:01:48.000000Z",
      "updated_at": "2026-03-21T21:01:48.000000Z"
    },
    {
      "id": 2,
      "name": "Roupas",
      "slug": "roupas",
      "products_count": 6,
      "created_at": "2026-03-21T21:01:48.000000Z",
      "updated_at": "2026-03-21T21:01:48.000000Z"
    }
  ]
}
```

---

### 6. LISTAR PRODUTOS

```http
GET /api/products
GET /api/products?per_page=10
GET /api/products?category=1
GET /api/products?min_price=100&max_price=5000
GET /api/products?search=smartphone
GET /api/products?sort_by=price_asc
GET /api/products?sort_by=newest&per_page=20
```

**Resposta (200):**
```json
{
  "data": [
    {
      "id": 1,
      "category_id": 1,
      "name": "Smartphone Samsung Galaxy S24",
      "slug": "smartphone-samsung-galaxy-s24",
      "description": "Produto de qualidade superior com excelente acabamento e durabilidade.",
      "price": 3999.00,
      "stock": 50,
      "image_url": "https://via.placeholder.com/300x300?text=Galaxy+S24",
      "category": {
        "id": 1,
        "name": "Eletrônicos",
        "slug": "eletronicos"
      },
      "created_at": "2026-03-21T21:01:48.000000Z",
      "updated_at": "2026-03-21T21:01:48.000000Z"
    }
  ],
  "pagination": {
    "total": 30,
    "per_page": 12,
    "current_page": 1,
    "last_page": 3
  }
}
```

---

### 7. OBTER DETALHES DE UM PRODUTO

```http
GET /api/products/smartphone-samsung-galaxy-s24
```

**Resposta (200):**
```json
{
  "data": {
    "id": 1,
    "category_id": 1,
    "name": "Smartphone Samsung Galaxy S24",
    "slug": "smartphone-samsung-galaxy-s24",
    "description": "Produto de qualidade superior com excelente acabamento e durabilidade.",
    "price": 3999.00,
    "stock": 50,
    "image_url": "https://via.placeholder.com/300x300?text=Galaxy+S24",
    "category": {
      "id": 1,
      "name": "Eletrônicos",
      "slug": "eletronicos"
    },
    "created_at": "2026-03-21T21:01:48.000000Z",
    "updated_at": "2026-03-21T21:01:48.000000Z"
  }
}
```

---

### 8. CRIAR PEDIDO

```http
POST /api/orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 3,
      "quantity": 1
    }
  ]
}
```

**Resposta (201):**
```json
{
  "message": "Order created successfully",
  "data": {
    "id": 1,
    "user_id": 11,
    "status": "pending",
    "total": 8197.00,
    "created_at": "2026-03-23T22:14:30.000000Z",
    "updated_at": "2026-03-23T22:14:30.000000Z",
    "items": [
      {
        "id": 1,
        "order_id": 1,
        "product_id": 1,
        "quantity": 2,
        "unit_price": 3999.00,
        "product": {
          "id": 1,
          "name": "Smartphone Samsung Galaxy S24",
          "price": 3999.00
        }
      },
      {
        "id": 2,
        "order_id": 1,
        "product_id": 3,
        "quantity": 1,
        "unit_price": 199.00,
        "product": {
          "id": 3,
          "name": "Fone de Ouvido JBL T750",
          "price": 199.00
        }
      }
    ]
  }
}
```

---

### 9. LISTAR PEDIDOS DO USUÁRIO

```http
GET /api/orders
Authorization: Bearer {token}
```

**Resposta (200):**
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 11,
      "status": "pending",
      "total": 8197.00,
      "created_at": "2026-03-23T22:14:30.000000Z",
      "updated_at": "2026-03-23T22:14:30.000000Z",
      "items": [
        {
          "id": 1,
          "order_id": 1,
          "product_id": 1,
          "quantity": 2,
          "unit_price": 3999.00,
          "product": { }
        }
      ]
    }
  ]
}
```

---

### 10. OBTER DETALHES DE UM PEDIDO

```http
GET /api/orders/1
Authorization: Bearer {token}
```

**Resposta (200):**
```json
{
  "data": {
    "id": 1,
    "user_id": 11,
    "status": "pending",
    "total": 8197.00,
    "created_at": "2026-03-23T22:14:30.000000Z",
    "items": [ ]
  }
}
```

---

### 11. DASHBOARD ADMIN

```http
GET /api/admin/dashboard
Authorization: Bearer {admin_token}
```

**Resposta (200):**
```json
{
  "data": {
    "total_orders": 5,
    "total_revenue": 45000.50,
    "pending_orders": 2,
    "total_products": 30,
    "low_stock_products": 3
  }
}
```

---

### 12. LISTAR TODOS OS PEDIDOS (ADMIN)

```http
GET /api/admin/orders
GET /api/admin/orders?page=1
Authorization: Bearer {admin_token}
```

**Resposta (200):**
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 11,
      "status": "pending",
      "total": 8197.00,
      "user": {
        "id": 11,
        "name": "João Silva",
        "email": "joao@example.com"
      },
      "items": [ ]
    }
  ],
  "pagination": {
    "total": 5,
    "per_page": 20,
    "current_page": 1,
    "last_page": 1
  }
}
```

---

### 13. ATUALIZAR STATUS DE PEDIDO (ADMIN)

```http
PUT /api/admin/orders/1
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "status": "processing"
}
```

**Status válidos:** `pending`, `processing`, `shipped`, `delivered`, `cancelled`

**Resposta (200):**
```json
{
  "message": "Order status updated",
  "data": {
    "id": 1,
    "status": "processing",
    ...
  }
}
```

---

### 14. CRIAR PRODUTO (ADMIN)

```http
POST /api/admin/products
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "category_id": 1,
  "name": "Novo Produto",
  "slug": "novo-produto",
  "description": "Descrição detalhada do produto",
  "price": 299.99,
  "stock": 100,
  "image_url": "https://via.placeholder.com/300x300?text=Novo"
}
```

**Resposta (201):**
```json
{
  "message": "Product created successfully",
  "data": {
    "id": 31,
    "category_id": 1,
    "name": "Novo Produto",
    "slug": "novo-produto",
    "description": "Descrição detalhada do produto",
    "price": 299.99,
    "stock": 100,
    "image_url": "https://via.placeholder.com/300x300?text=Novo",
    "created_at": "2026-03-23T22:20:00.000000Z",
    "updated_at": "2026-03-23T22:20:00.000000Z"
  }
}
```

---

### 15. ATUALIZAR PRODUTO (ADMIN)

```http
PUT /api/admin/products/1
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "name": "Smartphone Samsung Galaxy S25",
  "price": 4299.99,
  "stock": 40
}
```

**Resposta (200):**
```json
{
  "message": "Product updated successfully",
  "data": {
    "id": 1,
    "name": "Smartphone Samsung Galaxy S25",
    "price": 4299.99,
    "stock": 40,
    ...
  }
}
```

---

### 16. DELETAR PRODUTO (ADMIN)

```http
DELETE /api/admin/products/1
Authorization: Bearer {admin_token}
```

**Resposta (200):**
```json
{
  "message": "Product deleted successfully"
}
```

---

## ❌ Respostas de Erro

### 401 - Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

### 403 - Forbidden
```json
{
  "error": "Unauthorized. Admin access required."
}
```

### 404 - Not Found
```json
{
  "error": "Product not found"
}
```

### 422 - Validation Error
```json
{
  "message": "The email field is required. (and 1 more error)",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

### 400 - Bad Request
```json
{
  "error": "Product out of stock"
}
```

---

## 💻 Exemplos com JavaScript/Fetch

### Register & Login
```javascript
async function register() {
  const response = await fetch('http://localhost:8000/api/register', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      name: 'João Silva',
      email: 'joao@example.com',
      password: 'senha123',
      password_confirmation: 'senha123'
    })
  });
  
  const data = await response.json();
  localStorage.setItem('token', data.token);
  return data;
}

async function login() {
  const response = await fetch('http://localhost:8000/api/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      email: 'joao@example.com',
      password: 'senha123'
    })
  });
  
  const data = await response.json();
  localStorage.setItem('token', data.token);
  return data;
}
```

### Get Products
```javascript
async function getProducts(page = 1, category = null, sortBy = 'newest') {
  let url = `http://localhost:8000/api/products?per_page=12&page=${page}&sort_by=${sortBy}`;
  
  if (category) {
    url += `&category=${category}`;
  }
  
  const response = await fetch(url);
  return await response.json();
}
```

### Create Order
```javascript
async function createOrder(items) {
  const token = localStorage.getItem('token');
  
  const response = await fetch('http://localhost:8000/api/orders', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    },
    body: JSON.stringify({ items })
  });
  
  return await response.json();
}
```

---

## 🧪 Testar com PowerShell

```powershell
.\test-api.ps1
```

---

## 📚 Documentação Completa

Veja `README.md` para documentação completa da API e guia de desenvolvimento.
