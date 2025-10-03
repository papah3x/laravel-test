<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities
If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

# Real Estate Bookings – InnovQube Internship Task

## Overview

- **[Goal]** Build a small real-estate booking app with Laravel, Blade, TailwindCSS, and Alpine. Breeze handles auth. Manager can manage bookings; client can browse properties and request bookings.
- **[Status]** Functional app with auth, properties, client bookings, manager booking workflows, local seeded images, and calculated totals.

## Tech Stack

- **Backend:** Laravel 11 (PHP 8.1+)
- **Frontend:** Blade, TailwindCSS, Alpine.js
- **Auth:** Laravel Breeze (Blade)
- **DB:** MySQL
- **Build:** Vite, NPM

## Features

- **Authentication:** Login/Register via Breeze.
- **Role routing:** Redirects to `client.dashboard` or `manager.dashboard` based on `users.role`.
- **Properties:** Seeded demo properties with local curated images (`resources/assets/*`).
- **Client booking:**
  - Request booking from dashboard or property details.
  - Prevents date overlap against pending/confirmed.
  - Auto-calculates `total_price` = nights × `price_per_night`.
- **Manager booking:**
  - View/filter bookings, create/edit, confirm, cancel (with decline note).
  - Client sees decline note in dashboard bookings list.
- **UI/UX:**
  - Clean dashboards, property cards, modals (Alpine).
  - App bar avatar + email. Global bottom-right footer note.

## Getting Started

### Prerequisites

- PHP 8.1+, Composer, MySQL, Node.js + npm, Git

### Setup

1. Install dependencies
   - Backend: `composer install`
   - Frontend: `npm install`
2. Configure `.env`
   - Database connection (DB_*), `APP_URL=http://localhost:8000`
3. Generate app key
   - `php artisan key:generate`
4. Link storage (once)
   - `php artisan storage:link`
5. Build frontend
   - Dev: `npm run dev`
   - Prod: `npm run build`
6. Migrate and seed
   - `php artisan migrate:fresh --seed`

### Run the app

- `php artisan serve` → http://localhost:8000

## Seeded Data & Images

- Properties are created by `database/seeders/PropertySeeder.php`.
- Images are copied from `resources/assets/` to `public/storage/properties/`.
- Verify an image: open `/storage/properties/modern-city-loft.jpg` in browser.

## Key Files

- Routing: `routes/web.php`
- Layouts:
  - App: `resources/views/layouts/app.blade.php`
  - Guest: `resources/views/layouts/guest.blade.php`
- Navigation: `resources/views/layouts/navigation.blade.php`
- Client:
  - Dashboard: `resources/views/client/dashboard.blade.php`
  - Property details: `resources/views/client/properties/show.blade.php`
  - Booking store: `app/Http/Controllers/Client/ClientBookingController.php`
- Manager:
  - Bookings controller: `app/Http/Controllers/Manager/BookingController.php`
  - Bookings index view: `resources/views/manager/bookings/index.blade.php`
- Seeders:
  - `database/seeders/DatabaseSeeder.php`
  - `database/seeders/PropertySeeder.php`

## Notable Behaviors

- Booking overlap check considers `pending` and `confirmed` as blocking.
- Client booking `total_price` calculated server-side with Carbon date diff.
- Manager cancel stores a note; client sees “Reason: …” under cancelled bookings.

## Scripts and Commands

- Dev server: `php artisan serve`
- Build assets: `npm run dev` or `npm run build`
- Fresh DB + seed: `php artisan migrate:fresh --seed`
- Seed properties only: `php artisan db:seed --class=Database\\Seeders\\PropertySeeder`
- Routes list: `php artisan route:list`

## Screenshots (to include)

- Login/Register
- Client dashboard: properties grid, recent bookings with statuses and decline reason
- Property details page with booking modal
- Manager bookings index and actions

## Further Improvements

- Convert booking flows to Livewire components for real-time UX.
- Add Filament admin panel for CRUD on properties/bookings and RBAC.
- Add Policies/Gates for role-based access at model level.
- Notifications for booking confirmed/cancelled.
- More tests: booking creation, price calc, overlap prevention.

## Contact

- Deliverables and documentation to: `rh@innovqube.com`
