# API Testing Script for ShopFlow
# This script tests all endpoints and the frontend integration

$BASE_URL = "http://localhost:8000/api"
$ADMIN_EMAIL = "admin@shopflow.com"
$ADMIN_PASSWORD = "password"

Write-Host "=== ShopFlow API Testing ===" -ForegroundColor Green

# 1. Test Registration
Write-Host "`n[1] Testing User Registration..." -ForegroundColor Yellow
$newUser = @{
    name = "Test Customer"
    email = "test@example.com"
    password = "password123"
    password_confirmation = "password123"
} | ConvertTo-Json

try {
    $regResponse = Invoke-WebRequest -Uri "$BASE_URL/register" `
        -Method POST `
        -ContentType "application/json" `
        -Body $newUser `
        -UseBasicParsing 2>/dev/null

    $regData = $regResponse.Content | ConvertFrom-Json
    Write-Host "[OK] Registration successful" -ForegroundColor Green
    Write-Host "  Email: $($regData.user.email), Token: $($regData.token.Substring(0, 20))..."
    $CUSTOMER_TOKEN = $regData.token
    $CUSTOMER_ID = $regData.user.id
} catch {
    Write-Host "[FAIL] Registration failed" -ForegroundColor Red
}

# 2. Test Login
Write-Host "`n[2] Testing Admin Login..." -ForegroundColor Yellow
$loginBody = @{
    email = $ADMIN_EMAIL
    password = $ADMIN_PASSWORD
} | ConvertTo-Json

try {
    $loginResponse = Invoke-WebRequest -Uri "$BASE_URL/login" `
        -Method POST `
        -ContentType "application/json" `
        -Body $loginBody `
        -UseBasicParsing

    $loginData = $loginResponse.Content | ConvertFrom-Json
    Write-Host "[OK] Login successful" -ForegroundColor Green
    Write-Host "  Role: $($loginData.user.role), Token: $($loginData.token.Substring(0, 20))..."
    $ADMIN_TOKEN = $loginData.token
    $ADMIN_ID = $loginData.user.id
} catch {
    Write-Host "[FAIL] Login failed" -ForegroundColor Red
}

# 3. Get Categories
Write-Host "`n[3] Testing Get Categories..." -ForegroundColor Yellow
try {
    $catResponse = Invoke-WebRequest -Uri "$BASE_URL/categories" `
        -Method GET `
        -UseBasicParsing

    $catData = $catResponse.Content | ConvertFrom-Json
    $categoryCount = @($catData.data).Count
    Write-Host "[OK] Found $categoryCount categories" -ForegroundColor Green
    $catData.data | ForEach-Object { Write-Host "  - $($_.name) '$($_.products_count) products'" }
} catch {
    Write-Host "[FAIL] Get categories failed" -ForegroundColor Red
}

# 4. Get Products
Write-Host "`n[4] Testing Get Products..." -ForegroundColor Yellow
try {
    $prodResponse = Invoke-WebRequest -Uri "$BASE_URL/products?per_page=5" `
        -Method GET `
        -UseBasicParsing

    $prodData = $prodResponse.Content | ConvertFrom-Json
    $productCount = @($prodData.data).Count
    Write-Host "[OK] Found $productCount products (showing 5)" -ForegroundColor Green
    $prodData.data | Select-Object -First 3 | ForEach-Object { Write-Host "  - $($_.name) - R$$($_.price)" }
    Write-Host "  ... (Total: $($prodData.pagination.total) products)"
} catch {
    Write-Host "[FAIL] Get products failed" -ForegroundColor Red
}

# 5. Test Get Current User
Write-Host "`n[5] Testing Get Current User..." -ForegroundColor Yellow
$headers = @{ Authorization = "Bearer $ADMIN_TOKEN" }
try {
    $meResponse = Invoke-WebRequest -Uri "$BASE_URL/me" `
        -Method GET `
        -Headers $headers `
        -UseBasicParsing

    $meData = $meResponse.Content | ConvertFrom-Json
    Write-Host "[OK] Current user: $($meData.user.name) '$($meData.user.role)'" -ForegroundColor Green
} catch {
    Write-Host "[FAIL] Get current user failed" -ForegroundColor Red
}

# 6. Test Create Order
Write-Host "`n[6] Testing Create Order..." -ForegroundColor Yellow
$orderBody = @{
    items = @(
        @{ product_id = 1; quantity = 2 },
        @{ product_id = 2; quantity = 1 }
    )
} | ConvertTo-Json -Depth 10

$custHeaders = @{ Authorization = "Bearer $CUSTOMER_TOKEN" }
try {
    $orderResponse = Invoke-WebRequest -Uri "$BASE_URL/orders" `
        -Method POST `
        -ContentType "application/json" `
        -Headers $custHeaders `
        -Body $orderBody `
        -UseBasicParsing

    $orderData = $orderResponse.Content | ConvertFrom-Json
    Write-Host "[OK] Order created successfully" -ForegroundColor Green
    Write-Host "  Order ID: $($orderData.data.id), Status: $($orderData.data.status), Total: R$$($orderData.data.total)"
    $ORDER_ID = $orderData.data.id
} catch {
    Write-Host "[FAIL] Create order failed" -ForegroundColor Red
}

# 7. Test Get User Orders
Write-Host "`n[7] Testing Get User Orders..." -ForegroundColor Yellow
try {
    $ordersResponse = Invoke-WebRequest -Uri "$BASE_URL/orders" `
        -Method GET `
        -Headers $custHeaders `
        -UseBasicParsing

    $ordersList = $ordersResponse.Content | ConvertFrom-Json
    $userOrderCount = @($ordersList.data).Count
    Write-Host "[OK] User has $userOrderCount orders" -ForegroundColor Green
} catch {
    Write-Host "[FAIL] Get orders failed" -ForegroundColor Red
}

# 8. Test Admin Dashboard
Write-Host "`n[8] Testing Admin Dashboard..." -ForegroundColor Yellow
$adminHeaders = @{ Authorization = "Bearer $ADMIN_TOKEN" }
try {
    $dashResponse = Invoke-WebRequest -Uri "$BASE_URL/admin/dashboard" `
        -Method GET `
        -Headers $adminHeaders `
        -UseBasicParsing

    $dashData = $dashResponse.Content | ConvertFrom-Json
    Write-Host "[OK] Dashboard Stats:" -ForegroundColor Green
    Write-Host "  Total Orders: $($dashData.data.total_orders)"
    Write-Host "  Total Revenue: R$$($dashData.data.total_revenue)"
    Write-Host "  Pending Orders: $($dashData.data.pending_orders)"
    Write-Host "  Total Products: $($dashData.data.total_products)"
} catch {
    Write-Host "[FAIL] Admin dashboard failed" -ForegroundColor Red
}

# 9. Test Get Admin Products
Write-Host "`n[9] Testing Admin Get Products..." -ForegroundColor Yellow
try {
    $adminProdResponse = Invoke-WebRequest -Uri "$BASE_URL/admin/products" `
        -Method GET `
        -Headers $adminHeaders `
        -UseBasicParsing

    $adminProdData = $adminProdResponse.Content | ConvertFrom-Json
    $adminProdCount = @($adminProdData.data).Count
    Write-Host "[OK] Admin view: $adminProdCount products" -ForegroundColor Green
} catch {
    Write-Host "[FAIL] Admin get products failed" -ForegroundColor Red
}

# 10. Test Logout
Write-Host "`n[10] Testing Logout..." -ForegroundColor Yellow
try {
    $logoutResponse = Invoke-WebRequest -Uri "$BASE_URL/logout" `
        -Method POST `
        -Headers $adminHeaders `
        -UseBasicParsing

    $logoutData = $logoutResponse.Content | ConvertFrom-Json
    Write-Host "[OK] Logout successful" -ForegroundColor Green
} catch {
    Write-Host "[FAIL] Logout failed" -ForegroundColor Red
}

Write-Host "`n=== All Tests Complete ===" -ForegroundColor Green
Write-Host "`nAPI is ready for frontend integration!" -ForegroundColor Cyan
Write-Host "Frontend should connect to: http://localhost:8000/api" -ForegroundColor Cyan
