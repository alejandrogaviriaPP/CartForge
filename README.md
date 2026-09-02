# CartForge

Minimalist e-commerce built with Laravel. It offers a fluid shopping experience with internationalization (EN/ES), email-based two-factor authentication, product listings with ratings and reviews, a wishlist, and order history with delivery estimates.

## Screenshots

![Storefront](https://github.com/user-attachments/assets/154abd16-4a29-489b-89c3-23de6e283c39)

![Admin panel](https://github.com/user-attachments/assets/506906e7-efcf-4531-b8cd-a0b8719dbb92)

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

php artisan migrate --seed
npm run build

php artisan serve
```
