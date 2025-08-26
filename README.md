## Little Rabbit

A Laravel eCommerce project for kids’ clothing & accessories


## Overview

Little Rabbit is a modern eCommerce application built with Laravel Framework 12.23.1 and mySQL, designed for selling children’s clothing and accessories.

It demonstrates:

Clean architecture with Eloquent ORM relationships (1–1, 1–many, many–many).

A full-featured product catalog with categories, colors, sizes, seasons, brands, materials, and inventory management.

Authentication, roles, and order management.

Responsive frontend built.

This project is designed as a portfolio piece to showcase Laravel, database design, and full-stack development skills.


## Features

- Product Management – CRUD for clothing & accessories

- Categories & Tags – organize products easily

- Cart & Checkout – session-based cart, order placement

- User Accounts – authentication, profile, order history

- Order & Inventory – track stock & customer orders

- Admin Dashboard – manage products, users, and reports

- Testing – PHPUnit feature & unit tests


## Tech Stack

Backend: Laravel 12.23.1, PHP 8.2

Database: mySQL

Frontend: Blade, TailwindCSS, Alpine.js

DevOps: Docker (local dev), GitHub Actions (CI/CD), Render/Heroku (deployment)

Other: Faker factories, Laravel seeders, REST API endpoints


## Installation

Clone the repository

git clone https://github.com/athucngo-dot/littlerabbit.git
cd littlerabbit


Install dependencies

composer install
npm install && npm run dev


Configure environment

cp .env.example .env
php artisan key:generate


Set up database

Update .env with your mySQL credentials

Run migrations & seeders:

php artisan migrate --seed


Start development server

php artisan serve


## Database Schema (simplified)

The project includes 16 tables with real relationships:

lr_users – admins, users, guests to manage inventory

customers – customers buying products

products – clothing & accessories

categories – product grouping

colors, sizes, seasons, brands, materials – product variations

deals – product deals

reviews – customer product reviews

orders – customer purchases

order_product – products in each order

addresses – shipping/billing info

payments – payment records

cart - customer's cart which will be saved in a period of 1 month


## Screenshots (examples)
to be added later


## Testing

Run the test suite with:

php artisan test


## Deployment

Local: via Docker or php artisan serve

Production: Render / Heroku (ready to deploy with PostgreSQL add-on)


## License

This project is open-sourced under the MIT license

