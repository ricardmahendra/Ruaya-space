<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// This bootstraps the Laravel application
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

// Enable the service providers
$app->make(\Illuminate\Database\DatabaseManager::class);

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

try {
    // Check if admin already exists
    $existingAdmin = User::where('email', 'admin@ruaya.space')->first();
    
    if ($existingAdmin) {
        // Update existing admin
        $existingAdmin->update([
            'name' => 'Administrator',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);
        echo "✓ Admin user updated successfully\n";
        echo "Email: admin@ruaya.space\n";
        echo "Password: admin123\n";
    } else {
        // Create new admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ruaya.space',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);
        echo "✓ Admin user created successfully\n";
        echo "Email: admin@ruaya.space\n";
        echo "Password: admin123\n";
    }
    
    exit(0);
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

