## Little Rabbit

A Laravel eCommerce project for kids' clothing & accessories


## Overview

Little Rabbit is a modern eCommerce application built with Laravel Framework 12 and MySQL, designed for selling children's clothing and accessories.

It demonstrates:

- Clean architecture with Eloquent ORM relationships including one–one, one–many, many–many.

- A full-featured product catalog with categories, colors, sizes, brands, materials, and inventory management.

- Authentication, roles, and order management.

- Responsive frontend built with Blade and TailwindCSS.

- Content Management System (CMS) to manage product inventory.

This project is designed as a portfolio piece to showcase Laravel, database design, and full-stack development skills.


## Features

- New Release, Deals & Categories – organize products easily

- Cart & Checkout – cookie/database based cart, order placement

- User Accounts – authentication, profile, order history

- Sections 'You may also like' & 'Recently Viewed' – product recommendations based on user activities

- Search & Filters – find products by gender, size, brand, category, price, etc.

- Reviews & Ratings – customer feedback on products (not yet completed)

- Content Management System (CMS) – CRUD for managing products, categories, deals, brands, colors, sizes, materials (not yet completed)

- Admin Dashboard – manage user accounts (not yet completed)

- Responsive Design – mobile-friendly UI with TailwindCSS, Alpine.js

- Testing – PHPUnit feature & unit tests (not yet completed)

## Tech Stack

- Backend: Laravel 12, PHP 8.2

- Database: MySQL

- Frontend: Blade, Vite, TailwindCSS, Alpine.js

- DevOps: Docker, GitHub (version control), VPS (Cloudways)

- Other: Faker factories, Laravel seeders, REST API endpoints, caching system Redis, event listeners, schedule cron jobs, Meilisearch, Stripe payment (Stripe PaymentIntents, Webhook handling)

## Database Schema (simplified)

The project includes the following tables with relationships (not include the many-to-many pivot tables):

- users – admins, users, guests to manage inventory

- customers – customers buying products

- addresses – customer addresses information

- products – clothing & accessories

- categories – product grouping

- colors, sizes, brands, materials – product variations

- deals – product deals

- images – product images

- reviews – customer product reviews

- orders – customer purchases

- order_product – product details in each order

- order_addresses – billing/mailing addresses for each order

- payments – payment records

- cart – customer  cart 

- recently_viewed – products recently viewed by customers

- webhook_events – Stripe webhook events

## Database Diagram (simplified)

These diagrams illustrate the database schema and relationships between tables. They include only the main entities (tables) and their associations (relationships via foreign keys).

Generated with dbdiagram.io

Overall database diagram:
https://littlerabbit.anh-thuc-ngo.com/storage/docs/db_diagrams/db_diagram.png

Database diagram by sections:
- Products, categories, colors, sizes, brands, materials diagram:
https://littlerabbit.anh-thuc-ngo.com/storage/docs/db_diagrams/db_diagram_product.png

- Customers diagram:
https://littlerabbit.anh-thuc-ngo.com/storage/docs/db_diagrams/db_diagram_customer.png

- Cart & payments diagram:
https://littlerabbit.anh-thuc-ngo.com/storage/docs/db_diagrams/db_diagram_cart_payment.png


## Portfolio Live Test

The live version of this project can be accessed at:
https://littlerabbit.anh-thuc-ngo.com/

* Note: 
- This is a demo site for portfolio/learning purposes only. No actual sales or shipping will occur.

- Using test payment method provided by Stripe for checkout. Please do not use any real personal or payment information.

- Some content is seeded and some is sourced from other websites for demonstration purposes only.

- Meilisearch is used for product search functionality. However, the content is not fully correct mapped (category, color, size ... ) due to time constraints during development. Therefore, search results may not be accurate or complete.

## Content Management System (CMS)

The CMS live version of this project can be accessed at:
https://littlerabbit.anh-thuc-ngo.com/cms/login

For CMS access, please contact me directly.

## Installation

### 1. Clone the repository

git clone https://github.com/athucngo-dot/littlerabbit.git
cd littlerabbit

### 2. Install backend dependencies

composer install

### 3. Configure environment

cp .env.example .env 
php artisan key:generate

Set up your database and other environment variables in the `.env` file.

### 4. Run migrations & seeders

php artisan migrate --seed

### 5. Install frontend dependencies & build assets

npm install
npm run build

### 6. Start development server

php artisan serve

## Testing

Run the test suite with:

php artisan test

## Architecture Decisions

### Key Design Patterns & Decisions

Fast and easy development with maintainability and scalability in mind.

The application follows a modular, maintainable, scalable, and easily extendable architecture with separation of concerns:

- Handle database relationships with Eloquent ORM 
- Follow Model-View-Controller (MVC) architectural pattern
- Integrate RESTful API endpoints for future integrations
- Handle frontend interactivity with Blade + Tailwind + Alpine.js 
- Optimize performance using Redis & Meilisearch.
- Handle payment processing securely with Stripe.
- Ensure consistent development and production environments using Docker.
- Ensure server scalability and reliability with VPS hosting 
- Track changes, branch, and merge code using GitHub.

### Laravel Framework
- The application is built with Laravel Framework to keep development and deployment simple. It provides built-in features for rapid, secure, and scalable web development.

- It follows the Model-View-Controller (MVC) architectural pattern

- It has built-in Object-Relational Mapper (Eloquent ORM), which simplifies database interactions

- It includes Blade Templating Engine which helps create reusable components and layouts

### MySQL   
  MySQL is open-source, high-performance, reliable, scalable, and easy to use. It has strong community support and widely used for web applications.

### Redis Caching
  
  Redis is known for its high performance. It caches frequently accessed data (e.g., product listings) to reduce database load and improve response times.

### Meilisearch
  Meilisearch is an open-source, fast, and easy-to-use search engine requiring minimal configuration. It is used for product search functionality to provide fast and relevant search results.

### Tailwind CSS Framework  
  Tailwind CSS allows rapid UI development with low-level utility classes. It provides flexibility and customizability for responsive design.

### Alpine.js
  Alpine.js is a lightweight JavaScript framework for adding interactivity to the frontend. It integrates well with Blade templates.

### Vite build tool

- Vite offers fast development server startup and optimized build process.
  
- It integrates well with Laravel, Tailwind CSS and multiple js frameworks, including Alpine.js.

### Stripe Payment Processing

- Stripe is a popular payment gateway with robust API and extensive documentation.

- It supports various payment methods and currencies.

- It is used to handle payments securely and reliably. 

- It allows easy integration of the payment process into the website with minimal coding effort.

### VPS Hosting (Cloudways)
  Cloudways VPS handles server scaling, backups, and uptime monitoring, allowing focus on application development.

### Docker
  Docker ensures identical local and production environments, simplifying deployment and scaling.

### Version Control with GitHub  
  GitHub is used for version control and collaboration. It allows tracking changes, branching, and merging code efficiently.

## Screenshots

### Homepage

Homepage with featured products, discount deals, menu bar and buttons to navigate to different sections.

![Homepage](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/homepage.jpg)

### Product Listing Page

Product details with size, color, quantity selection and add-to-cart flow.

![Product Listing Page](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/new_arrival.jpg)

### Product Detail Page

Detailed product information with images, description, feature, reviews, related & recommended products.

![Product Detail Page](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/product_detail.jpg)

### Add to Cart & Cart Page

Adding items to cart flow with selected size, color, quantity.

![Add Item to Cart](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/add_item_to_cart.jpg)

Cart page listing items with ability to update quantity or remove items.

![Cart Page](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/cart_preview.jpg)

### Checkout & Order Confirmation

Checkout flow with delivery information & payment method (Stripe).

![Checkout Page](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/checkout.jpg)

Order confirmation page after successful payment.

![Order Confirmation](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/success_payment.jpg)

### Customer Dashboard - Orders History

Listing of customer order history with details.

![Customer Dashboard - Orders History](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/order_history.jpg)

### Login & Registration

Authentication for customers to access their dashboard.

![Login Page](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/login.jpg)

### Content Management System (CMS) - Login

Authentication for admin users to access the CMS.

![CMS Login](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/cms_login.jpg)

### CMS - Products Management

Admin interface for listing products with search and pagination.

![CMS Products List](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/cms_product_list.jpg)

### CMS - Edit Product

Admin interface for editing product name, description, pricing, stock, color, size, categories, images and other details.

![CMS Edit Product](https://littlerabbit.anh-thuc-ngo.com/storage/docs/screenshots/cms_product_edit.jpg)

## License

This project is open-sourced software licensed under the MIT license.

