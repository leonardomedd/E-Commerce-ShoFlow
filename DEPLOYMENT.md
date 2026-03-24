# 🚀 ShopFlow - Guia de Deployment

Instruções completas para configurar e executar a plataforma ShopFlow em desenvolvimento ou produção.

## 📋 Pré-requisitos

### Windows (XAMPP)
- [XAMPP](https://www.apachefriends.org/) (PHP 8.3, MySQL 5.7+, Apache)
- [Node.js 18+](https://nodejs.org/)
- [Git](https://git-scm.com/)

### Mac/Linux
- PHP 8.3+ com composer
- MySQL 5.7+
- Node.js 18+
- Git

## 🔧 Setup Inicial

### 1. Clonar Repositório
```bash
cd path/to/projects
git clone <repo-url> ShopFlow
cd ShopFlow
```

### 2. Backend Setup

```bash
cd backend

# Instalar dependências PHP
composer install

# Copiar arquivo de ambiente
cp .env.example .env

# Gerar app key
php artisan key:generate

# Configurar banco de dados em .env
# DB_HOST=127.0.0.1
# DB_DATABASE=shopflow
# DB_USERNAME=root
# DB_PASSWORD=

# Criar banco de dados
mysql -u root -e "CREATE DATABASE shopflow;"

# Executar migracoes
php artisan migrate

# Popular banco de dados
php artisan db:seed

# (Opcional) Limpar cache
php artisan cache:clear
```

### 3. Frontend Setup

```bash
cd frontend

# Instalar dependências Node
npm install

# (Opcional) Verificar se API está em localhost:8000/api
# Adicionar em .env.local se necessário:
# VITE_API_BASE_URL=http://localhost:8000/api
```

## 🚀 Começar a Desenvolver

### Terminal 1: Backend (Laravel Server)
```bash
cd backend
php artisan serve

# Saída:
# INFO  Server running on [http://127.0.0.1:8000].
```

### Terminal 2: Frontend (Vite Dev Server)
```bash
cd frontend
npm run dev

# Saída:
# ➜  local:   http://localhost:5173/
```

### Terminal 3: MySQL (se não estiver rodando via XAMPP)
```bash
# Windows/XAMPP
Start-Process "C:\xampp\mysql\bin\mysqld.exe" -WindowStyle Hidden

# Mac/Linux
mysql.server start
```

## ✅ Verificação

### Testar API
```powershell
# Windows PowerShell
.\test-api.ps1

# bash/zsh
bash test-api.sh
```

### URLs de Acesso
- **Frontend**: http://localhost:5173
- **API**: http://localhost:8000/api
- **Admin Dashboard**: http://localhost:5173/admin

### Credenciais Padrão
```
Email: admin@shopflow.com
Senha: password
```

## 🗄️ Gerenciar Banco de Dados

### Resetar Banco Completamente
```bash
cd backend

# (Cuidado!) Resetar tudo
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

### Adicionar Dados via CLI
```bash
cd backend

# Entrar no Tinker (SQL REPL)
php artisan tinker

# Criar usuário
User::create([
  'name' => 'Novo Admin',
  'email' => 'admin2@shopflow.com',
  'password' => bcrypt('password'),
  'role' => 'admin'
]);

# Criar produto
Product::create([
  'category_id' => 1,
  'name' => 'Novo Produto',
  'slug' => 'novo-produto',
  'description' => 'Descrição',
  'price' => 99.99,
  'stock' => 50,
  'image_url' => 'https://via.placeholder.com/300'
]);

# Sair com exit
exit
```

### Verificar Dados
```bash
cd backend

# Ver usuários
php artisan tinker
User::all();

# Ver produtos
Product::with('category')->limit(5)->get();

# Ver pedidos
Order::with('user', 'items')->get();
```

## 📦 Build para Produção

### Frontend
```bash
cd frontend

# Build otimizado
npm run build

# Saída em: frontend/dist/
# Upload para servidor web (Nginx, Apache, etc)
```

### Backend
```bash
cd backend

# Configurar .env para produção
# APP_DEBUG=false
# APP_ENV=production

# Instalr com --no-dev
composer install --no-dev --optimize-autoloader

# Otimizar cache
php artisan config:cache
php artisan route:cache
```

## 🌐 Deploy em Servidor

### Opção 1: Traditional Server (VPS/Shared Hosting)

```bash
# No servidor
cd /var/www/shopflow

# Backend
cd backend
composer install --no-dev
php artisan migrate --force
php artisan db:seed --force

# Frontend
cd frontend
npm install
npm run build

# Configurar Nginx/Apache para servir:
# - /backend/public (API)
# - /frontend/dist (Frontend)
```

### Opção 2: Docker

```dockerfile
# Dockerfile para backend
FROM php:8.3-fpm
RUN docker-php-ext-install pdo pdo_mysql
COPY backend /var/www/html
WORKDIR /var/www/html
RUN composer install --no-dev
RUN php artisan migrate --force

# Dockerfile para frontend
FROM node:18-alpine
COPY frontend /app
WORKDIR /app
RUN npm install && npm run build
```

### Opção 3: PaaS (Heroku, Railway, etc)

```bash
# Heroku
heroku create shopflow
git push heroku main

# Railway
railway init
railway link  # link ao projeto
railway up
```

## 🛡️ Segurança em Produção

### Backend .env
```
APP_DEBUG=false
APP_ENV=production
APP_KEY=<generate with php artisan key:generate>

# Database
DB_HOST=<remote-host>
DB_USERNAME=<secure-user>
DB_PASSWORD=<strong-password>

# Email
MAIL_DRIVER=sendgrid
MAIL_FROM_ADDRESS=noreply@shopflow.com

# JWT Secret (se usar)
JWT_SECRET=<generated-secret>
```

### Frontend .env
```
VITE_API_BASE_URL=https://api.shopflow.com/api
```

### Nginx Config (exemplo)
```nginx
server {
  listen 80;
  server_name shopflow.com;

  # Backend
  location /api/ {
    proxy_pass http://backend:8000;
    proxy_set_header Host $host;
  }

  # Frontend
  location / {
    try_files $uri $uri/ /index.html;
    root /var/www/frontend/dist;
  }
}
```

## 🔍 Troubleshooting

### "Connection refused" - MySQL
```bash
# Verificar se MySQL está rodando
# Windows
Get-Process mysqld

# Mac/Linux
ps aux | grep mysql

# Iniciar
# Windows
Start-Process "C:\xampp\mysql\bin\mysqld.exe" -WindowStyle Hidden

# Mac/Linux
mysql.server start
```

### "Port 8000 already in use"
```bash
# Usar porta diferente
php artisan serve --port=8001

# Ou matar processo
# Windows
Get-Process -Name php | Stop-Process

# Mac/Linux
lsof -i :8000 | tail -1 | awk '{print $2}' | xargs kill -9
```

### "Composer memory limit"
```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

### "Node modules conflicts"
```bash
cd frontend
rm -rf node_modules package-lock.json
npm install
```

## 📊 Monitoring

### Logs

```bash
# Backend
tail -f backend/storage/logs/laravel.log

# Frontend (durante dev)
npm run dev
```

### Database

```bash
# Verificar conexões
mysql -u root
SHOW PROCESSLIST;

# Verificar tamanho
SELECT table_schema, SUM(data_length + index_length) 
FROM information_schema.tables 
GROUP BY table_schema;
```

### Performance

```bash
# Backend queries
cd backend
php artisan debugbar
# Acessa em ?debugbar=1 em cada página

# Frontend bundle size
cd frontend
npm run build
# Verifica tamanho em dist/
```

## 🔄 CI/CD Setup

### GitHub Actions (.github/workflows/test.yml)
```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    services:
      mysql:
        image: mysql:5.7
        env:
          MYSQL_DATABASE: shopflow_test
          MYSQL_ROOT_PASSWORD: password
    steps:
      - uses: actions/checkout@v3
      - uses: php-actions/composer@v6
      - run: cd backend && php artisan test
      - uses: actions/setup-node@v3
      - run: cd frontend && npm install && npm run build
```

## 📝 Backup & Restore

### Backup
```bash
# Database
mysqldump -u root -p shopflow > backup_$(date +%Y%m%d).sql

# Files (backend)
tar -czf backend_backup_$(date +%Y%m%d).tar.gz backend/

# Files (frontend dist)
tar -czf frontend_backup_$(date +%Y%m%d).tar.gz frontend/dist/
```

### Restore
```bash
# Database
mysql -u root -p shopflow < backup_20260323.sql

# Files
tar -xzf backend_backup_20260323.tar.gz
tar -xzf frontend_backup_20260323.tar.gz
```

## 📚 Documentação Relacionada

- [README.md](./README.md) - Visão geral do projeto
- [API_EXAMPLES.md](./API_EXAMPLES.md) - Exemplos de requests
- [Laravel Documentation](https://laravel.com/docs)
- [React Documentation](https://react.dev)

## 🆘 Suporte

Para problemas ou dúvidas:
1. Verificar logs: `backend/storage/logs/`
2. Verificar console do navegador (F12)
3. Rodar script de teste: `test-api.ps1`
4. Verificar conectividade: `curl http://localhost:8000/api/categories`

---

**ShopFlow** - E-Commerce Platform | 2026
