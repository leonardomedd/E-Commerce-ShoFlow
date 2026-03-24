<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = App\Models\User::create([
    'name' => 'Leonardo Test',
    'email' => 'leonardo@test.com',
    'password' => bcrypt('password'),
    'role' => 'customer'
]);

echo "✓ User created: " . $user->email . " (ID: " . $user->id . ")\n";
