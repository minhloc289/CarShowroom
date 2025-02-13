# Car Showroom Management System

## Introduction

This is a **Web Programming** course project aimed at building a car showroom management system. The project is developed using **Laravel Framework**, providing core functionalities such as car buying, renting, accessory management, and online payment integration.

## Technologies Used

- **Programming Languages**: PHP, HTML, Tailwind CSS, Javascript
- **Database**: MySQL

## Main Features

### 1. Accessories

- Users can:
  - View the shopping cart
  - Add accessories to the cart

### 2. Compare and Buy Cars

- Users can:
  - Compare different car models before making a decision.
  - Make online payments via **VNPay** (test environment).

### 3. Car Rental

- Users can:
  - Choose available cars to rent.
  - Schedule rental dates.
  - Pay deposits online through **VNPay**.
  - Extend the rental period when it expires.

### 4. Additional Features

- **Test Drive Management**:
  - Users can register for test drives and manage their appointments.
- **Employee Management**:
  - Admin can add, edit, delete, and manage showroom employee information.
- **Revenue Statistics**:
  - Display charts and statistical data on car sales, rentals, and accessory revenues.

### 5. Email Notifications

- The system automatically sends emails for:
  - Purchase and rental invoices.
  - Payment status updates.

---

## How to Run the Project

1. **Clone the repository**:
   ```bash
   git clone https://github.com/minhloc289/CarShowroom.git
   ```
2. **Install dependencies**:
   ```bash
   composer install
   composer require maatwebsite/excel --ignore-platform-reqs
   ```
3. **Configure the .env file**:
   ```bash
   cp .env.example .env
   ```
4. **Run database migrations**:
   - Prioritize running specific tables first: `order`, `rental_order`
   - Copy paths of migration files:
     ```bash
     php artisan migrate --path=/database/migrations/...
     ```
   - Run all migrations:
     ```bash
     php artisan migrate
     ```
5. **Run the project**:
   ```bash
   php artisan serve
   ```
6. **Access the application**:
   Open your browser and navigate to `http://localhost:8000`.

---


