# Admin User Setup Guide

## Overview
This guide provides multiple methods to create an admin user account for the Ruaya Space application.

**Default Admin Credentials:**
- Email: `admin@ruaya.space`
- Password: `admin123`

## Method 1: Using the Setup Script (Recommended)

### Option A: Using setup_admin_user.php
This is the easiest method that uses Laravel's ORM directly.

```bash
php setup_admin_user.php
```

**What it does:**
- Checks if admin user already exists
- Creates or updates the admin user
- Sets the role to 'admin'
- Verifies the user was created successfully

### Option B: Using Laravel Artisan with Database Seeder
If you haven't run migrations yet, run them first:

```bash
php artisan migrate
```

Then run the seeder to create both admin and staff users:

```bash
php artisan db:seed
```

This will create:
- **Admin:** admin@ruaya.space / admin123 (role: admin)
- **Staff:** staff@ruaya.space / staff123 (role: staff)

## Method 2: Using MySQL Directly

```bash
mysql -h 127.0.0.1 -u root -p'' Ruaya_space < create_admin_user.sql
```

This method directly inserts the admin user into the database using SQL.

## Database Requirements

Ensure the following columns exist in the `users` table:
- `id` (primary key)
- `name` (string)
- `email` (string, unique)
- `password` (string, hashed)
- `role` (string) - used for admin/staff role assignment
- `created_at`, `updated_at` (timestamps)

If the `role` column doesn't exist, run migrations:

```bash
php artisan migrate
```

## Verification

After creating the admin user, verify by logging in:
1. Go to `http://localhost/login` (or your application URL)
2. Enter email: `admin@ruaya.space`
3. Enter password: `admin123`
4. You should be logged in as admin

## Changing Admin Password

To change the admin password later, you can:

1. **Via Artisan Tinker:**
   ```bash
   php artisan tinker
   >>> $user = App\Models\User::where('email', 'admin@ruaya.space')->first();
   >>> $user->password = Hash::make('newpassword');
   >>> $user->save();
   ```

2. **Via the application UI:**
   - Login to your account
   - Go to password reset/settings section
   - Change your password through the application interface

## Files Created

- `setup_admin_user.php` - Main setup script (recommended)
- `create_admin.php` - Alternative PHP setup
- `create_admin_user.sql` - SQL script for database insertion
- `setup_admin.sh` - Bash script wrapper
- `database/seeders/DatabaseSeeder.php` - Updated to safely handle admin/staff creation

## Troubleshooting

**Error: "SQLSTATE[HY000]: General error: 1030"**
- Ensure database exists and migrations have been run
- Run: `php artisan migrate`

**Error: "Base table or view not found"**
- Run migrations first: `php artisan migrate`

**Password not working after creation**
- Make sure you're using the exact password: `admin123`
- Passwords are hashed using bcrypt automatically
- If still not working, run the setup script again to update the password

## Security Notes

⚠️ **Important for Production:**
- This admin account with password `admin123` is for development/testing only
- For production environments:
  - Use a strong, unique password
  - Update the password immediately after setup
  - Consider using environment variables for sensitive credentials
  - Enable two-factor authentication if available
  - Limit admin access to specific IP ranges
