# YourLab - Multi-Tenant Project Management Application

A Laravel-based multi-tenant project management system with path-based tenancy, built with Livewire 3 and featuring a Bitbucket-inspired UI.

## 🎯 Features

- **Multi-tenancy**: Path-based tenant isolation (`/t/{tenant}/...`)
- **Single Database**: All tenants share one database with proper isolation
- **Organization Management**: Users can create and join multiple organizations
- **Project Management**: Create, update, and track projects per organization
- **Task Management**: Manage tasks within projects with status tracking
- **Clean Architecture**: Service and Repository pattern implementation
- **Modern UI**: Bitbucket-inspired design with Tailwind CSS
- **Real-time Updates**: Livewire 3 for reactive components

## 📋 Requirements

- PHP 8.2+
- MySQL 5.7+
- Composer
- Node.js & NPM

## 🚀 Installation

### 1. Clone and Install Dependencies

```bash
cd c:\xampp\htdocs\yourlab
composer install
npm install && npm run dev
```

### 2. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourlab
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 📖 Usage Guide

### Creating Your First Organization

1. **Register**: Create an account at `/register`
2. **Login**: Sign in at `/login`
3. **Create Organization**: Navigate to `/organizations` and click "Create New Organization"
4. **Enter Organization Name**: Provide a name (e.g., "Acme Corp")
5. **Access Dashboard**: You'll be redirected to `/t/{tenant-id}/` 

### Managing Projects

**Create a Project:**
- Navigate to: `/t/{tenant-id}/projects`
- Click "New Project"
- Fill in project details (name, description, dates, status)
- Submit to create

**View Projects:**
- All projects listed at `/t/{tenant-id}/projects`
- Filter by status: Draft, Active, Completed
- Click "View" to see project details

### Managing Tasks

**Create a Task:**
- Navigate to: `/t/{tenant-id}/tasks`
- Click "New Task"
- Select project, enter title, description, assign user
- Set status: To Do, In Progress, Done

**Update Task Status:**
- Tasks can be updated inline from the task list
- Use dropdown to change status quickly

### Switching Organizations

- Use the "Switch Organization" dropdown in the top navigation
- Access multiple organizations with one account
- Each organization has isolated data

## 🗂️ Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Central/          # Non-tenant controllers
│   │   │   └── OrganizationController.php
│   │   └── Tenant/           # Tenant-specific controllers
│   │       ├── DashboardController.php
│   │       ├── ProjectController.php
│   │       └── TaskController.php
│   └── Middleware/
│       └── CheckTenantAccess.php
├── Livewire/                  # Livewire components
│   ├── OrganizationSwitcher.php
│   ├── ProjectList.php
│   └── TaskList.php
├── Models/
│   ├── Project.php
│   ├── Task.php
│   ├── Tenant.php
│   └── User.php
├── Repositories/              # Data access layer
│   ├── ProjectRepository.php
│   └── TaskRepository.php
└── Services/                  # Business logic
    ├── ProjectService.php
    ├── TaskService.php
    └── TenantService.php

database/
├── migrations/
│   ├── tenant/               # Tenant-specific migrations
│   │   ├── 2025_11_03_000001_create_projects_table.php
│   │   └── 2025_11_03_000002_create_tasks_table.php
│   ├── 2019_09_15_000010_create_tenants_table.php
│   ├── 2019_09_15_000020_create_domains_table.php
│   └── 2025_11_03_130313_create_tenant_user_table.php

resources/
├── views/
│   ├── central/              # Central app views
│   │   └── organizations/
│   ├── tenant/               # Tenant app views
│   │   ├── dashboard.blade.php
│   │   ├── projects/
│   │   └── tasks/
│   ├── layouts/
│   │   ├── app.blade.php     # Central layout
│   │   └── tenant.blade.php  # Tenant layout
│   └── livewire/             # Livewire component views
```

## 🔧 Configuration

### Tenancy Configuration

Path-based tenancy is configured in `config/tenancy.php`:
- **Tenant Model**: `App\Models\Tenant`
- **Central Connection**: `mysql`
- **Single Database**: All tenants share the main database
- **Automatic Scoping**: Tenant ID automatically added to queries

### Routes

**Central Routes** (`routes/web.php`):
- `/` - Home page
- `/login` - Login
- `/register` - Registration
- `/organizations` - Organization dashboard
- `/organizations/create` - Create organization

**Tenant Routes** (`routes/tenant.php`):
- `/t/{tenant}` - Tenant dashboard
- `/t/{tenant}/projects` - Projects
- `/t/{tenant}/tasks` - Tasks

## 🎨 UI Design

The application features a Bitbucket-inspired design with:
- **Primary Color**: `#0052CC` (Atlassian Blue)
- **Light Background**: `#F4F5F7`
- **Border Color**: `#DFE1E6`
- **Clean Cards**: Rounded borders with subtle shadows
- **Responsive**: Mobile-friendly layouts

## 🔐 Security Features

- **Tenant Isolation**: Automatic scoping ensures data separation
- **Access Control**: Middleware checks user access to tenants
- **Role-Based Access**: Admin and Member roles per organization
- **Laravel Authentication**: Built-in auth with Breeze

## 🧪 Testing

Create a test user and organization:

```bash
php artisan tinker
```

```php
// Create user
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password')
]);

// Create tenant
$tenant = App\Models\Tenant::create([
    'id' => 'acme',
    'name' => 'Acme Corporation'
]);

// Link user to tenant
$tenant->users()->attach($user->id, ['role' => 'admin']);
```

## 📚 Key Concepts

### Path-Based Tenancy
- URL format: `/t/{tenant-id}/resource`
- Example: `/t/acme/projects`
- Tenant context initialized automatically

### Global Scopes
- Models automatically filter by tenant_id
- No manual filtering required in queries
- Prevents cross-tenant data leaks

### Service/Repository Pattern
- **Repositories**: Handle database operations
- **Services**: Contain business logic
- **Controllers**: Coordinate between services and views

## 🐛 Troubleshooting

**Issue: Tenant not found**
- Ensure tenant ID in URL matches database
- Check `/organizations` for correct tenant ID

**Issue: Access denied**
- Verify user is linked to tenant in `tenant_user` table
- Check role assignment

**Issue: Data not showing**
- Confirm tenant context is initialized
- Check global scopes are working

## 📝 Next Steps

To enhance the application:
1. Add user invitation system
2. Implement file uploads for projects
3. Add email notifications
4. Create task comments/activity log
5. Build reporting dashboard
6. Add API endpoints
7. Implement team permissions

## 🤝 Contributing

This is a demonstration project built with:
- Laravel 11
- Livewire 3.6
- stancl/tenancy 3.9
- Tailwind CSS (CDN)

## 📄 License

Open-source software licensed under the MIT license.

---

**Built with ❤️ using Laravel Multi-Tenancy**
