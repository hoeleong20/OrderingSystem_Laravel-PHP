# Restaurant Ordering System

A full-featured restaurant ordering system built with **Laravel 11** and **PHP 8.2+**. The system supports menu management, online ordering with cart functionality, table/dish/event reservations, discount management, and integrates with external Java and Python microservices.

## Features

- **Menu Management** - Admin CRUD for menu items with status tracking (active, soldOut, archived)
- **Order & Cart System** - Add items to cart with customizable remarks (e.g. Add Cheese, Less Spicy), checkout and payment processing
- **Reservation System** - Support for table, dish, table+dish, and event reservations
- **Discount System** - Promo code management with percentage/fixed discounts, criteria-based eligibility
- **User Management** - Role-based access (admin/user), email verification, profile management with bank account verification
- **XML/XSLT Integration** - Data transformation and rendering using XML and XSLT stylesheets

## Design Patterns Used

| Pattern | Usage |
|---------|-------|
| **Decorator** | Menu item remarks/modifications (Add Cheese, No Veg, etc.) |
| **Factory** | Discount calculation (PercentageDiscount, FixedDiscount) |
| **Composite** | Reservation management (TableReservation, DishReservation, EventReservation) |
| **Observer** | Order lifecycle tracking and event firing on status changes |
| **Template Method** | Login flow differentiation (UserLogin vs AdminLogin) |
| **Event/Listener** | Order payment triggers kitchen notification via REST API |

## Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Frontend:** Blade templates, Tailwind CSS, Vite
- **Database:** MySQL
- **Auth:** Laravel Breeze with email verification
- **External Services:** Python API (inventory), Java API (discount verification, kitchen notifications), Bank verification API

## Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL (via XAMPP or standalone)

## Setup

### 1. Clone the repository

```bash
git clone https://github.com/hoeleong20/OrderingSystem_Laravel-PHP.git
cd OrderingSystem_Laravel-PHP
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure the database

Update `.env` with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restaurant-ordering-system
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Configure external services (optional)

Update `.env` with your external service URLs if different from defaults:

```
PYTHON_API_URL=http://127.0.0.1:5000
JAVA_API_URL=http://localhost:8080
BANK_API_URL=http://localhost:8081
```

### 6. Configure mail (optional)

For email verification, configure your mail settings in `.env`. Example using Mailtrap:

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 7. Run migrations

```bash
php artisan migrate
```

### 8. Seed the database (optional)

```bash
php artisan db:seed
```

### 9. Build frontend assets

```bash
npm run build
```

### 10. Start the server

```bash
php artisan serve
```

Visit [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Project Structure

```
app/
  Decorators/       - Decorator pattern for menu remarks
  Events/           - Application events (OrderUpdated)
  Factories/        - Factory pattern for discounts
  Http/Controllers/ - Route controllers
  Listeners/        - Event listeners (KitchenListener)
  Models/
    Composite/      - Composite pattern for reservations
  Observers/        - Model observers (Order, CartItem)
  Template/         - Template method pattern for login
config/
database/
  migrations/       - Database schema
  seeders/          - Database seeders
resources/
  views/
    xslt/           - XSLT stylesheets
routes/
  web.php           - Application routes
```

## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
