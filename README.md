# CartForge

Minimalist e-commerce built with Laravel. It offers a fluid shopping experience with internationalization (EN/ES), email-based two-factor authentication, product listings with ratings and reviews, a wishlist, and order history with delivery estimates.

## Features

- Product catalog with detail pages, image galleries, star ratings, and comments
- Shopping cart and wishlist
- Order history with delivery estimates
- Email-based two-factor authentication on login
- Internationalization (English / Spanish) with instant language switching
- Country and phone number selection at registration
- Mobile-first responsive design with a Liquid Glass aesthetic

## Requirements

- PHP >= 8.2
- Composer
- Node.js and npm
- SQLite (default) or any database supported by Laravel

## Installation

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate
npm run build

php artisan serve
```
