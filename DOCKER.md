# 🐳 Docker Setup for YourLab

Complete guide for running YourLab multi-tenant application with Docker.

## 📋 Prerequisites

- **Docker Desktop** (Windows/Mac) or **Docker Engine** (Linux)
- **Git**
- At least 4GB RAM allocated to Docker

## 🚀 Quick Start

### 1. Clone and Setup

```bash
# Clone the repository
git clone https://github.com/jospintedjou/yourlab.git
cd yourlab

# Copy environment file
cp .env.example .env

# Start Docker containers
docker-compose up -d
```

### 2. Install Dependencies and Initialize

```bash
# Install PHP dependencies
docker-compose exec laravel.test composer install

# Generate application key
docker-compose exec laravel.test php artisan key:generate

# Run migrations
docker-compose exec laravel.test php artisan migrate

# Run tenant migrations
docker-compose exec laravel.test php artisan tenants:migrate

# Install and build frontend assets
docker-compose exec laravel.test npm install
docker-compose exec laravel.test npm run build
```

### 3. Access the Application

- **Application**: http://localhost
- **Vite Dev Server**: http://localhost:5173

## 🛠️ Common Commands

### Starting & Stopping

```bash
# Start containers in background
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs

# Follow logs in real-time
docker-compose logs -f
```

### Development

```bash
# Run artisan commands
docker-compose exec laravel.test php artisan [command]

# Run composer commands
docker-compose exec laravel.test composer [command]

# Run npm commands
docker-compose exec laravel.test npm [command]

# Run tests
docker-compose exec laravel.test php artisan test

# Access container shell
docker-compose exec laravel.test bash

# Access MySQL CLI
docker-compose exec mysql mysql -u sail -p

# Access Redis CLI
docker-compose exec redis redis-cli
```

### Frontend Development

```bash
# Start Vite dev server (with hot reload)
docker-compose exec laravel.test npm run dev

# Build for production
docker-compose exec laravel.test npm run build
```

### Using Laravel Sail (Optional Shortcut)

Laravel Sail is included as a convenience wrapper. Instead of typing `docker-compose exec laravel.test`:

```bash
# These are equivalent:
docker-compose exec laravel.test php artisan migrate
./vendor/bin/sail artisan migrate

docker-compose exec laravel.test composer install
./vendor/bin/sail composer install

docker-compose exec laravel.test npm run dev
./vendor/bin/sail npm run dev
```

**Create an alias** (optional) to use `sail` instead of `./vendor/bin/sail`:

**Windows (PowerShell)**:
```powershell
Set-Alias sail './vendor/bin/sail'
```

**Linux/Mac (Bash/Zsh)**:
```bash
alias sail='./vendor/bin/sail'
```

## 🏢 Multi-Tenancy with Docker

### Creating Organizations/Tenants

1. Register a user at http://localhost/register
2. Create an organization from the dashboard
3. Each organization gets its own database automatically

### Tenant Migrations

```bash
# Run migrations for all tenants
docker-compose exec laravel.test php artisan tenants:migrate

# Run migrations for specific tenant
docker-compose exec laravel.test php artisan tenants:migrate --tenants=tenant-id

# Rollback tenant migrations
docker-compose exec laravel.test php artisan tenants:rollback
```

## 🔧 Configuration

### Environment Variables

Key Docker-specific variables in `.env`:

```env
# Application
APP_URL=http://localhost
APP_PORT=80

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=yourlab
DB_USERNAME=sail
DB_PASSWORD=password

# Redis
REDIS_HOST=redis

# Mail (logs to storage/logs/laravel.log)
MAIL_MAILER=log

# Docker Ports
FORWARD_DB_PORT=3306
FORWARD_REDIS_PORT=6379
VITE_PORT=5173
```

### Port Conflicts

If default ports are already in use, change them in `.env`:

```env
APP_PORT=8080              # Change from 80
FORWARD_DB_PORT=33060      # Change from 3306
FORWARD_REDIS_PORT=63790   # Change from 6379
VITE_PORT=5174             # Change from 5173
```

## 🧪 Running Tests

```bash
# Run all tests
docker-compose exec laravel.test php artisan test

# Or using Sail
./vendor/bin/sail test

# Run specific test suite
docker-compose exec laravel.test php artisan test --testsuite=Feature

# Run specific test file
docker-compose exec laravel.test php artisan test tests/Feature/ProjectManagementTest.php

# Run with coverage
docker-compose exec laravel.test php artisan test --coverage
```

## 🐛 Troubleshooting

### Containers won't start

```bash
# Check Docker is running
docker ps

# Check for port conflicts
docker-compose down
docker-compose up -d

# Rebuild containers
docker-compose build --no-cache
docker-compose up -d
```

### Database connection errors

```bash
# Verify MySQL is running
docker-compose ps

# Check MySQL logs
docker-compose logs mysql

# Reset database
docker-compose exec laravel.test php artisan migrate:fresh
```

### Permission errors (Linux)

```bash
# Set proper ownership
sudo chown -R $USER:$USER .

# Or set user ID in .env before starting
WWWUSER=$(id -u) WWWGROUP=$(id -g) docker-compose up -d
```

### Clear cache

```bash
docker-compose exec laravel.test php artisan config:clear
docker-compose exec laravel.test php artisan cache:clear
docker-compose exec laravel.test php artisan view:clear
docker-compose exec laravel.test php artisan route:clear
```

## 📦 Database Management

### Backup Database

```bash
# Backup central database
docker-compose exec mysql mysqldump -u sail -ppassword yourlab > backup.sql

# Backup specific tenant database
docker-compose exec mysql mysqldump -u sail -ppassword tenant-id_yourlab > tenant-backup.sql
```

### Restore Database

```bash
docker-compose exec -T mysql mysql -u sail -ppassword yourlab < backup.sql
```

## 🚀 Production Deployment

For production, use optimized Docker images:

```bash
# Optimize autoloader
docker-compose exec laravel.test composer install --optimize-autoloader --no-dev

# Cache configuration
docker-compose exec laravel.test php artisan config:cache
docker-compose exec laravel.test php artisan route:cache
docker-compose exec laravel.test php artisan view:cache

# Build production assets
docker-compose exec laravel.test npm run build
```

## 💡 Tips

### Laravel Sail is Optional

Sail is just a convenience wrapper around `docker-compose`. You can use standard Docker Compose commands:

```bash
# Without Sail
docker-compose up -d
docker-compose exec laravel.test php artisan migrate

# With Sail (same thing)
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
```

Use whichever you prefer!

### Performance Tips

1. **Increase Docker resources**: Allocate at least 4GB RAM
2. **Use volume mounts efficiently**: Exclude `node_modules` and `vendor`
3. **Enable BuildKit**: Set `DOCKER_BUILDKIT=1` for faster builds

## 📚 Additional Resources

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Docker Documentation](https://docs.docker.com)
- [Stancl/Tenancy Documentation](https://tenancyforlaravel.com)

## 🆘 Support

If you encounter issues:
1. Check the troubleshooting section above
2. Review container logs: `./vendor/bin/sail logs`
3. Open an issue on GitHub with error details
