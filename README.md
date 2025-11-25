# Tutor Solution BD - Backend

A comprehensive educational platform backend built with Laravel 12 for **Tutor Solution BD**. This system provides a robust foundation for managing tutors, students, courses, and educational content. Optimized for shared hosting environments with full-featured user management, content delivery, and administrative capabilities.

## � Features

### Content Management

-   Dynamic banner management
-   Site settings and configuration
-   Social media integration
-   WhatsApp chat integration
-   Cookie consent management (GDPR compliant)
-   SEO-optimized URLs and meta tags

### User Management

-   Role-based access control (Admin, User)
-   User registration and authentication
-   Profile management
-   Mobile OTP verification
-   Secure password hashing
-   Session management

### Educational Features

-   Course and content delivery
-   Tutor and student management
-   Custom notifications system
-   Coupon and discount management
-   Multi-language support (EN/BN)
-   Analytics tracking

### Administrative Features

-   Comprehensive admin dashboard
-   User activity monitoring
-   Site-wide settings management
-   Banner and promotional content control
-   Social media links management
-   GDPR cookie consent

## �📋 Requirements

-   PHP 8.2 or higher
-   MySQL 5.7 or higher
-   Composer
-   Node.js & NPM
-   2GB RAM minimum (shared hosting optimized)

## 🛠️ Installation

1. **Clone the repository**

```bash
git clone <repository-url>
cd tutor-media-backend
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install JavaScript dependencies**

```bash
npm install
```

4. **Environment setup**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**
   Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tutor_media
DB_USERNAME=root
DB_PASSWORD=
```

6. **Run migrations**

```bash
php artisan migrate
```

7. **Build assets**

```bash
npm run build
```

8. **Start development server**

```bash
composer dev
```

Visit: `http://localhost:8000`

## 📦 Installed Packages

### PHP Packages

-   `spatie/laravel-permission` - Role-based access control
-   `spatie/laravel-medialibrary` - Media management
-   `intervention/image` - Image processing
-   `laravel/scout` - Full-text search
-   `meilisearch/meilisearch-php` - Search engine
-   `spatie/laravel-sitemap` - SEO sitemap
-   `barryvdh/laravel-dompdf` - PDF generation
-   `maatwebsite/excel` - Excel import/export
-   `twilio/sdk` - SMS/OTP functionality
-   `spatie/laravel-cookie-consent` - GDPR compliance
-   `spatie/laravel-login-link` - Magic link authentication
-   `spatie/laravel-settings` - Application settings management

### Frontend

-   Tailwind CSS 4.0
-   Vite
-   Vanilla JavaScript

## 🗄️ Database Structure

The project includes the following core tables:

-   **Users & Authentication**: users, sessions
-   **Content Management**: banners, site_settings, social_links
-   **Educational**: coupons, custom_notifications
-   **System**: settings, cache, cookie_consent, whatsapp_chats

## 🧪 Testing

Run tests with Pest PHP:

```bash
php artisan test
```

Run specific test:

```bash
php artisan test --filter UserTest
```

## 📚 Documentation

-   `README.md` - This file
-   `.env.example` - Environment configuration template

## 🔧 Development Commands

```bash
# Start development server with queue and vite
composer dev

# Run migrations
php artisan migrate

# Fresh migration
php artisan migrate:fresh

# Run tests
php artisan test

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generate sitemap
php artisan sitemap:generate
```

## 🏗️ Project Structure

```
tutor-media-backend/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   └── Auth/           # Authentication controllers
│   └── Models/             # Eloquent models
├── database/
│   └── migrations/         # Database migrations
├── resources/
│   ├── css/               # Tailwind CSS
│   ├── js/                # JavaScript files
│   └── views/             # Blade templates
│       ├── admin/         # Admin panel views
│       └── layouts/       # Layout templates
├── tests/
│   ├── Feature/           # Feature tests
│   └── Unit/              # Unit tests
└── public/                # Public assets
```

## 🔐 Security

-   CSRF protection enabled
-   SQL injection prevention (Eloquent ORM)
-   Mass assignment protection
-   Rate limiting ready
-   GDPR compliance ready
-   Secure password hashing
-   Session security

## ⚡ Performance

-   Database query optimization with indexes
-   Eager loading relationships
-   Caching strategies
-   Optimized for shared hosting (2GB RAM)
-   WebP image format support
-   Minified CSS/JS assets

## 🌍 SEO Features

-   Auto-generated slugs
-   Meta tags support
-   Sitemap generation
-   Schema.org markup ready
-   Canonical URLs
-   hreflang tags for multi-language

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Support

For support, contact the development team or open an issue in the repository.

## 📊 Status

**Current Version:** 1.0.0  
**Status:** Active Development  
**Last Updated:** November 25, 2025

---

Built with ❤️ for **Tutor Solution BD** using Laravel 12
