# CMS Application

Full-stack customer management system built with Laravel and Quasar.

## 🏗️ Project Structure

```
cms/
├── backend/          # Laravel API (PHP)
├── frontend/         # Quasar SPA (Vue 3)
└── package.json      # Root package for easy start up scripts
└── README.md
```

## ⚙️ Prerequisites

- **Node.js** 20+ LTS
- **PHP** 8.2+
- **Composer**
- **MySQL** or **PostgreSQL**

## 🚀 Quick Start
### 0. General Setup

```bash
npm install
# This installs root-level dependencies for easy start up scripts
```


### 1. Backend Setup

```bash
cd backend

# Install dependencies
composer install

# Configure environment
cp .env.example .env

# IMPORTANT: Edit .env before continuing
# - Set your database connection (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
# - You can also just keep the default SQLite setup for quick testing
# - Customize admin credentials if needed (ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD)

# Generate application key
php artisan key:generate

# Run migrations and seed database
php artisan migrate --seed

# Start development server
php artisan serve
```

**Note:** The seeder creates a default admin user with credentials from your `.env` file.

#### Optional: Generate Test Data

```bash
php artisan db:seed --class=CustomerSeeder
```

This creates 50 mock customers with German locale data.

### 2. Frontend Setup

```bash
cd frontend

# Install dependencies
npm install

# Configure environment
cp .env.example .env

# Start development server
quasar dev
```

## 🌐 Access the Application

- **Backend API:** http://localhost:8000
- **Frontend SPA:** http://localhost:9000

### Default Login Credentials

Use the credentials you set in `backend/.env`:
- **Email:** Value of `ADMIN_EMAIL` (default: admin@cms.de)
- **Password:** Value of `ADMIN_PASSWORD` (default: password)

⚠️ **Change these credentials in production!**

## 🛠️ Tech Stack

### Backend
- **Laravel 12** - PHP Framework
- **Laravel Sanctum** - API Authentication
- 
### Frontend
- **Quasar 2** - Vue 3 Framework
- **Vue 3** - Progressive JavaScript Framework
- **Pinia** - State Management
- **Axios** - HTTP Client
- **Heroicons** - Icon Library
- **Tailwind CSS 4** - Utility-first CSS

## 📁 Key Features

- ✅ Customer CRUD operations
- ✅ User authentication with tokens
- ✅ German localization

## 🚢 Deployment

### Backend

1. Set `APP_ENV=production` in `.env`
2. Run `composer install --optimize-autoloader --no-dev`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan migrate --force`

### Frontend

1. Run `quasar build`
2. Deploy `dist/spa` folder to your web server

## 📄 License

This project is open-source and available for personal and commercial use.

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!