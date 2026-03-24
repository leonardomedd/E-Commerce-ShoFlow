# ShopFlow E-Commerce Platform

Uma plataforma de e-commerce completa com frontend React 18 e backend Laravel 12.

## 📁 Estrutura do Projeto

```
E-commerce Project/
├── frontend/              # React 18 + Vite (Etapas 1-10)
├── backend/               # Laravel 12 API
├── test-api.ps1           # Script para testar endpoints
└── README.md              # Este arquivo
```

## 🚀 Stack Técnico

### Frontend
- **Framework**: React 18 com Vite
- **Estado**: Zustand (cartStore, authStore)
- **Animações**: Framer Motion
- **UI**: Tailwind CSS
- **Páginas**: Home, Produtos, Carrinho, Checkout, Login/Signup, Perfil, Admin

### Backend
- **Framework**: Laravel 12
- **Banco de Dados**: MySQL 5.7+
- **Autenticação**: API Tokens (Sanctum-compatible)
- **Server**: PHP 8.3 (via XAMPP)

## 🗄️ Banco de Dados

### Tabelas
- `users` - Usuários (admin/customer)
- `categories` - Categorias de produtos
- `products` - Produtos
- `orders` - Pedidos
- `order_items` - Itens de pedidos
- `addresses` - Endereços de usuários
- `api_tokens` - Tokens de autenticação

### Dados Padrão
- **Admin**: admin@shopflow.com / password
- **Categorias**: 5 (Eletrônicos, Roupas, Calçados, Livros, Casa)
- **Produtos**: 30 (distribuídos entre as categorias)
- **Clientes**: 10 (criados com Faker)

## 🔌 API Endpoints

### Autenticação (Público)
```
POST   /api/register              - Registrar novo usuário
POST   /api/login                 - Login (retorna token)
```

### Usuário (Autenticado)
```
GET    /api/me                    - Dados do usuário atual
POST   /api/logout                - Logout
```

### Produtos (Público)
```
GET    /api/products              - Listar produtos com filtros e paginação
GET    /api/products/{slug}       - Detalhes de um produto
GET    /api/categories            - Listar categorias
```

**Filtros de Produtos**:
- `?category={id}` - Filtrar por categoria
- `?min_price={valor}` - Preço mínimo
- `?max_price={valor}` - Preço máximo
- `?search={termo}` - Busca por nome/descrição
- `?sort_by={price_asc|price_desc|newest|name}` - Ordenação
- `?per_page={n}` - Itens por página (padrão: 12)

### Pedidos (Autenticado)
```
POST   /api/orders                - Criar novo pedido
GET    /api/orders                - Listar pedidos do usuário
GET    /api/orders/{id}           - Detalhes de um pedido
```

### Admin (Autenticado + Admin)
```
GET    /admin/dashboard           - Dashboard com stats
GET    /admin/products            - Listar todos os produtos (admin)
POST   /admin/products            - Criar produto
PUT    /admin/products/{id}       - Atualizar produto
DELETE /admin/products/{id}       - Deletar produto
GET    /admin/orders              - Listar todos os pedidos
PUT    /admin/orders/{id}         - Atualizar status do pedido
```

## 🛠️ Como Usar

### Iniciar Backend

```bash
# Navegar para pasta backend
cd backend

# Iniciar servidor
php artisan serve

# Servidor roda em: http://localhost:8000
```

### Iniciar Frontend

```bash
# Navegar para pasta frontend
cd frontend

# Instalar dependências
npm install

# Rodar em desenvolvimento
npm run dev

# Build para produção
npm run build
```

### Rodar Testes de API

```bash
# No PowerShell (Windows)
PowerShell -ExecutionPolicy Bypass -File .\test-api.ps1

# Ou diretamente
.\test-api.ps1
```

## 🔐 Autenticação

A API usa token-based authentication. Fluxo:

1. **Register/Login**: Enviar `email` e `password` → receber `token`
2. **Usar Token**: Incluir header `Authorization: Bearer {token}` em requests subsequentes
3. **Logout**: Enviar POST para `/api/logout` com token válido

Exemplo com JavaScript/Fetch:
```javascript
// Login
const response = await fetch('http://localhost:8000/api/login', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ email: 'user@example.com', password: 'password' })
});
const data = await response.json();
const token = data.token;

// Usar token em requests
fetch('http://localhost:8000/api/me', {
  headers: { 'Authorization': `Bearer ${token}` }
});
```

## 📦 Criar um Pedido

```bash
POST /api/orders
Content-Type: application/json
Authorization: Bearer {token}

{
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 3, "quantity": 1 }
  ]
}

Resposta:
{
  "message": "Order created successfully",
  "data": {
    "id": 1,
    "status": "pending",
    "total": 8497.00,
    "items": [...]
  }
}
```

## 📊 Dashboard Admin

Acesso em `/api/admin/dashboard` retorna:
- `total_orders` - Total de pedidos
- `total_revenue` - Receita total
- `pending_orders` - Pedidos pendentes
- `total_products` - Produtos cadastrados
- `low_stock_products` - Produtos com estoque < 10

## ✅ Funcionalidades Implementadas

### Frontend
- [x] Homepage com listagem de produtos
- [x] Página de detalhes de produto
- [x] Carrinho de compras com Framer Motion
- [x] Checkout em 3 etapas com validação
- [x] Autenticação (login/signup)
- [x] Página de perfil
- [x] Painel Admin com CRUD de produtos
- [x] Gerenciamento de pedidos (admin)

### Backend
- [x] API de autenticação (register/login/logout)
- [x] Listagem de produtos com filtros
- [x] Busca e paginação
- [x] Criação de pedidos
- [x] Histórico de pedidos (cliente)
- [x] Dashboard admin
- [x] CRUD de produtos (admin)
- [x] Gerenciamento de status de pedido (admin)
- [x] Validação de dados
- [x] Tratamento de erros

## 🔄 Integração Frontend-Backend

A configuração frontend aponta para:
```
API Base: http://localhost:8000/api
```

O `authService.js` no frontend:
- Intercepta requests com token de autenticação
- Handleia erros 401/403
- Auto-logout quando token expira

O `zustand store` (authStore):
- Salva token em localStorage
- Persiste entre sessões
- Gerencia estado de autenticação

## 🐛 Troubleshooting

### MySQL não inicia
```powershell
Start-Process "C:\xampp\mysql\bin\mysqld.exe" -WindowStyle Hidden
```

### Laravel server não inicia
```bash
# Verificar se porta 8000 está livre
npx -y get-port -- --ports 8000

# Ou usar porta diferente
php artisan serve --port=8001
```

### Erro de CORS
Adicionar origem frontend em `config/cors.php` do Laravel se necessário.

### Erro de Token Expirado
O frontend irá fazer logout automático e redirecionar para login.

## 📝 Commits

- `48472d9` - Initial backend API setup with auth, products, categories, orders endpoints

## 👨‍💻 Desenvolvimento

Para adicionar novos endpoints:

1. Criar controller: `php artisan make:controller Api/NomeController --api`
2. Adicionar rotas em `routes/api.php`
3. Criar migrations se necessário: `php artisan make:migration nome_migration`
4. Implementar lógica no controller
5. Testar com `test-api.ps1` ou Postman

## 📄 Licença

MIT

---

**ShopFlow** - Plataforma de E-Commerce Moderna | 2026
