#!/bin/bash

# Register test
echo "=== TESTE 1: Registro ===" 
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Teste User",
    "email": "teste@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

echo ""
echo "=== TESTE 2: Login (admin) ===" 
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@shopflow.com",
    "password": "password"
  }'

echo ""
echo "=== TESTE 3: Listar Produtos ===" 
curl -X GET "http://localhost:8000/api/products?per_page=5" \
  -H "Accept: application/json"

echo ""
echo "=== TESTE 4: Listar Categorias ===" 
curl -X GET http://localhost:8000/api/categories \
  -H "Accept: application/json"
