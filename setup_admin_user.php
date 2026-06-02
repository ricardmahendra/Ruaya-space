<?php
/**
 * Create Admin User Script for Ruaya Space
 * This script creates an admin account with the following credentials:
 * Email: admin@ruaya.space
 * Password: admin123
 */

define('LARAVEL_START', microtime(true));

// Load the Laravel framework
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Get the container and bootstrap Laravel
$app->make(\Illuminate\Contracts\Console\Kernel::class);

// Now we can use Laravel
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Ensure we're in the right timezone
date_default_timezone_set('Asia/Jakarta');

try {
    echo "========================================\n";
    echo "Admin User Creation Script\n";
    echo "========================================\n\n";
    
    $email = 'admin@ruaya.space';
    $password = 'admin123';
    $name = 'Administrator';
    
    // Check if user already exists
    $existingUser = User::where('email', $email)->first();
    
    if ($existingUser) {
        echo "[UPDATE] Found existing user with email: $email\n";
        echo "Updating user credentials...\n";
        
        $existingUser->update([
            'name' => $name,
            'password' => Hash::make($password),
            'role' => 'admin'
        ]);
        
        echo "✓ User updated successfully\n\n";
    } else {
        echo "[CREATE] Creating new admin user...\n";
        
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin'
        ]);
        
        echo "✓ User created successfully (ID: {$user->id})\n\n";
    }
    
    // Display the credentials
    echo "Admin Credentials:\n";
    echo "==================\n";
    echo "Email: $email\n";
    echo "Password: $password\n";
    echo "\n";
    
    // Verify
    $verifyUser = User::where('email', $email)->first();
    if ($verifyUser) {
        echo "✓ Verification: User found in database\n";
        echo "  - ID: {$verifyUser->id}\n";
        echo "  - Name: {$verifyUser->name}\n";
        echo "  - Email: {$verifyUser->email}\n";
        echo "  - Role: {$verifyUser->role}\n";
        echo "\n";
        echo "✓ Setup complete! You can now login with the above credentials.\n";
    } else {
        echo "✗ Verification failed: User not found in database\n";
        exit(1);
    }
    
} catch (Exception $e) {
    echo "\n✗ Error occurred:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    exit(1);
}

exit(0);
?>
