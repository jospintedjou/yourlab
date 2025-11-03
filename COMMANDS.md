# 🔧 Essential Commands Reference

## Development

```bash
# Start development server
php artisan serve

# Watch for frontend changes (if needed)
npm run dev

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Database

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration (⚠️ deletes all data)
php artisan migrate:fresh

# Check migration status
php artisan migrate:status
```

## Tinker (Testing)

```bash
# Open tinker console
php artisan tinker

# Create a test tenant
$tenant = App\Models\Tenant::create(['id' => 'test-company', 'name' => 'Test Company']);
$tenant->domains()->create(['domain' => 'test-company']);

# Create a test user
$user = App\Models\User::create(['name' => 'Test User', 'email' => 'test@test.com', 'password' => bcrypt('password')]);

# Link user to tenant as admin
$tenant->users()->attach($user->id, ['role' => 'admin']);

# View all tenants
App\Models\Tenant::all();

# View tenant users
App\Models\Tenant::find('test-company')->users;
```

## Useful Artisan Commands

```bash
# List all routes
php artisan route:list

# Create new Livewire component
php artisan make:livewire ComponentName

# Create new controller
php artisan make:controller ControllerName

# Create new model
php artisan make:model ModelName -m

# Clear all compiled files
php artisan optimize:clear
```

## Quick Fixes

```bash
# Permission issues (Windows XAMPP)
# Usually not needed, but if you see errors:
icacls "storage" /grant Users:F /t
icacls "bootstrap/cache" /grant Users:F /t

# Regenerate autoload
composer dump-autoload

# Clear everything and restart
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
```

## URLs for Testing

```bash
# Central App
http://localhost:8000/                    # Home
http://localhost:8000/register            # Register
http://localhost:8000/login               # Login
http://localhost:8000/organizations       # Organizations Dashboard

# Tenant App (replace {tenant-id} with actual ID)
http://localhost:8000/t/{tenant-id}               # Dashboard
http://localhost:8000/t/{tenant-id}/projects      # Projects
http://localhost:8000/t/{tenant-id}/tasks         # Tasks
```

## Common Scenarios

### Scenario 1: Create Full Test Setup
```php
php artisan tinker

// Create user
$user = App\Models\User::factory()->create([
    'email' => 'admin@test.com',
    'password' => bcrypt('password')
]);

// Create tenant
$tenant = App\Models\Tenant::create([
    'id' => 'acme-corp',
    'name' => 'Acme Corporation'
]);

// Link them
$tenant->users()->attach($user->id, ['role' => 'admin']);

// Verify
$user->tenants; // Should show Acme Corporation
```

### Scenario 2: Check Tenant Data
```php
php artisan tinker

// Initialize tenant context
$tenant = App\Models\Tenant::find('acme-corp');
tenancy()->initialize($tenant);

// Now create project (will auto-scope to tenant)
App\Models\Project::create([
    'name' => 'Website Redesign',
    'description' => 'New company website',
    'status' => 'active'
]);

// View projects for this tenant
App\Models\Project::all();
```

### Scenario 3: Reset Everything
```bash
# ⚠️ WARNING: This deletes ALL data
php artisan migrate:fresh

# Then re-seed if you have seeders
php artisan db:seed
```

## Environment Variables

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourlab
DB_USERNAME=root
DB_PASSWORD=

# App
APP_NAME="YourLab"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

## Troubleshooting Commands

```bash
# Check PHP version
php -v

# Check Laravel version
php artisan --version

# Check installed packages
composer show

# Verify database connection
php artisan tinker
DB::connection()->getPdo();

# Test Livewire
php artisan livewire:publish --config

# Check logs
tail -f storage/logs/laravel.log  # Linux/Mac
Get-Content storage/logs/laravel.log -Wait  # Windows PowerShell
```

## Production Deployment

```bash
# Set environment
APP_ENV=production
APP_DEBUG=false

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev

# Migrations
php artisan migrate --force
```

---

**Remember**: Always backup your database before running destructive commands!
