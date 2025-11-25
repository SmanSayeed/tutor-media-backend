# Tutor Media Backend

A comprehensive e-commerce platform built with Laravel 12 for selling fashion shoes online. Optimized for shared hosting environments with full-featured product management, order processing, and customer management.

## 🚀 Features

### Product Management

-   Categories and unlimited subcategories
-   Product variants (size, color, material)
-   Multiple product images with WebP support
-   Stock management and inventory tracking
-   Sale pricing with date ranges
-   Full-text search with Laravel Scout
-   SEO-optimized URLs and meta tags

### Order Management

-   Complete order lifecycle tracking
-   Multiple payment methods (COD, Stripe, PayPal)
-   Dynamic shipping zones
-   Order status management
-   Return request system
-   PDF invoice generation
-   Excel export functionality

### Customer Features

-   Customer registration and profiles
-   Wishlist system
-   Product reviews and ratings
-   Order history and tracking
-   Return request management
-   Mobile OTP verification

### Business Features

-   Marketing campaigns
-   Social media integration
-   WhatsApp chat integration
-   Analytics tracking
-   GDPR cookie consent
-   Multi-language support (EN/BN)

## 📋 Requirements

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
cp env-example.txt .env
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

### Frontend

-   Tailwind CSS 4.0
-   Vite
-   Vanilla JavaScript

## 🗄️ Database Structure

The project includes 23 tables:

-   Core: categories, subcategories, brands, products
-   E-commerce: orders, order_items, customers, wishlists
-   Business: campaigns, shipping_zones, return_requests, reviews
-   System: settings, social_links, notifications, analytics_events

## 🧪 Testing

Run tests with Pest PHP:

```bash
php artisan test
```

Run specific test:

```bash
php artisan test --filter CategoryTest
```

## 📚 Documentation

-   `PROJECT-SUMMARY.md` - Complete project summary
-   `development-plan.txt` - 100+ step development roadmap
-   `env-example.txt` - Environment configuration template

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
│   │   ├── Frontend/       # Frontend controllers
│   │   └── Auth/           # Authentication controllers
│   └── Models/             # Eloquent models (19 models)
├── database/
│   └── migrations/         # Database migrations (23 tables)
├── resources/
│   ├── css/               # Tailwind CSS
│   ├── js/                # JavaScript files
│   └── views/             # Blade templates
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

For support, email support@example.com or open an issue in the repository.

## 🎯 Roadmap

See `development-plan.txt` for the complete 100+ step development roadmap.

### Phase 1: Core Infrastructure ✅

-   Database design and migrations
-   Model creation with relationships
-   Controller generation
-   Testing framework setup

### Phase 2: Authentication & Authorization (In Progress)

-   User authentication
-   Role-based permissions
-   OTP verification
-   Password reset

### Phase 3: Admin Panel (Pending)

-   Dashboard
-   CRUD operations
-   Reporting features

### Phase 4: Frontend Development (Pending)

-   Responsive layouts
-   Product browsing
-   Shopping cart
-   Checkout flow

### Phase 5: Advanced Features (Pending)

-   Multi-language implementation
-   Payment gateway integration
-   Real-time notifications
-   Analytics integration

## 📊 Status

**Current Version:** 1.0.0  
**Status:** Phase 1 Complete - Ready for Phase 2  
**Last Updated:** October 14, 2025

---

Built with ❤️ using Laravel 12
