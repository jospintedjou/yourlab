# 🧪 YourLab - Multi-Tenant Project Management System

A modern, multi-tenant project and task management application built with Laravel 12, Livewire 3, and Stancl/Tenancy.

## ✨ Features

- 🏢 **Multi-Tenancy**: Each organization gets isolated data and database
- 📊 **Project Management**: Create, track, and manage projects with statuses
- ✅ **Task Management**: Organize tasks with priorities, due dates, and assignments
- 🎨 **Modern UI**: Built with Tailwind CSS and Alpine.js
- ⚡ **Real-time Updates**: Livewire for reactive interfaces
- 🔐 **Authentication**: Laravel Breeze with secure user management
- 🌍 **Localization**: French language support
- 🧪 **Fully Tested**: 87 tests with comprehensive coverage

## 🚀 Quick Start

### Option 1: Docker

```bash
git clone https://github.com/jospintedjou/yourlab.git
cd yourlab
cp .env.example .env

# Start containers
docker-compose up -d

# Install dependencies
docker-compose exec laravel.test composer install
docker-compose exec laravel.test php artisan key:generate
docker-compose exec laravel.test php artisan migrate
docker-compose exec laravel.test php artisan tenants:migrate

# Build assets
docker-compose exec laravel.test npm install
docker-compose exec laravel.test npm run build
```

**Access**: http://localhost  
📖 **[Full Docker Documentation](DOCKER.md)**

**Optional**: Use `./vendor/bin/sail` as a shortcut for `docker-compose exec laravel.test`

### Option 2: Local Development

```bash
git clone https://github.com/jospintedjou/yourlab.git
cd yourlab
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan tenants:migrate
npm install && npm run build
php artisan serve
```

## 🛠️ Tech Stack

- **Backend**: Laravel 12.x, PHP 8.2+
- **Frontend**: Livewire 3, Alpine.js 3, Tailwind CSS 3
- **Database**: MySQL (Docker) / SQLite (Local)
- **Multi-Tenancy**: Stancl/Tenancy v3.x
- **Authentication**: Laravel Breeze
- **Testing**: PHPUnit with 87 tests

## 📚 Project Structure

```
app/
├── DTO/              # Data Transfer Objects
├── Enums/            # Status, Priority enums
├── Livewire/         # Livewire components
├── Models/           # Eloquent models
├── Repositories/     # Data access layer
└── Services/         # Business logic

resources/views/
├── central/          # Central domain views
├── livewire/         # Livewire component views
└── layouts/          # App layouts

tests/
├── Feature/          # 72 feature tests
└── Unit/             # 15 unit tests
```

## 🐳 Docker Commands

```bash
# Start application
docker-compose up -d

# Run artisan commands
docker-compose exec laravel.test php artisan [command]

# Run tests
docker-compose exec laravel.test php artisan test

# Access shell
docker-compose exec laravel.test bash

# View logs
docker-compose logs -f

# Stop containers
docker-compose down
```

**Shortcut**: Use `./vendor/bin/sail` instead of `docker-compose exec laravel.test`

See [DOCKER.md](DOCKER.md) for complete Docker documentation.

## 🧪 Testing

```bash
# Docker
docker-compose exec laravel.test php artisan test

# Or with Sail shortcut
./vendor/bin/sail test

# Local
php artisan test

# Run specific suite
php artisan test --testsuite=Feature

# With coverage
php artisan test --coverage
```

**Test Coverage**: 87 tests, 240 assertions
- ✅ Unit Tests: Enums, DTOs
- ✅ Feature Tests: Auth, Projects, Tasks, Tenancy, Livewire Components

## 📖 Additional Documentation

- [Docker Setup](DOCKER.md) - Complete Docker guide
- [Setup Guide](SETUP_GUIDE.md) - Detailed installation
- [Commands Reference](COMMANDS.md) - Available artisan commands
- [Quick Start](QUICK_START.md) - Get started quickly
- [Tests Documentation](TESTS_DOCUMENTATION.md) - Testing guide

## 🤝 Contributing

Contributions are welcome! Please:
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the MIT license.

## 🙏 Credits

Built with:
- [Laravel](https://laravel.com)
- [Livewire](https://livewire.laravel.com)
- [Stancl/Tenancy](https://tenancyforlaravel.com)
- [Tailwind CSS](https://tailwindcss.com)

