# Retrova - Online Antique Store (PHP + MySQL)

A simple e-commerce app with Admin and User roles, product catalog, cart, and Razorpay payments.

## Features
- Admin: add/edit/delete products with images, categories, stock
- Users: browse/search/filter, product detail, cart, checkout
- Orders: Razorpay order creation, payment verification, order items, stock decrement
- Bootstrap 5 responsive UI

## Requirements
- XAMPP on Windows (Apache, PHP 8+, MySQL)
- PHP cURL enabled (for Razorpay API calls)
- Internet access for Bootstrap and Razorpay checkout.js

## Setup
1. Copy project to `c:\xampp\htdocs\Retrova\` (this repo already assumes that path).
2. Start Apache and MySQL from XAMPP Control Panel.
3. Create DB schema:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import file `db.sql` from the project root
   - Alternatively, first page load will auto-create the DB and admin user
4. Configure environment (optional):
   - Update `BASE_URL` in `config.php` if the folder name differs from `Retrova`
   - Razorpay test keys are set in `config.php` as:
     - `RAZORPAY_KEY_ID`: `rzp_test_RV0yV2urkxFXQM`
     - `RAZORPAY_KEY_SECRET`: `i2JCvv7IVXYIpcveFE649JPG`
   - Keep these as test keys; replace with live keys only in production
5. Visit app:
   - User storefront: http://localhost/Retrova/
   - Admin: http://localhost/Retrova/admin/
   - Admin login: username `admin`, password `admin123`

## Folder Structure
- `/assets/` static styles
- `/layout/` shared header/footer
- `/admin/` admin dashboard and product CRUD
- `/api/` Razorpay order creation and verification endpoints
- `/uploads/` product images (created on demand)

## Notes
- Login supports email or username in `login.php`
- Default admin is created automatically on first run if not present
- Payment flow:
  - `api/create_order.php` creates a Razorpay order based on cart total
  - `checkout.php` launches Razorpay Checkout
  - `api/verify_payment.php` validates signature, records order items, reduces stock, clears cart

## Troubleshooting
- If images don't upload, ensure Apache/PHP can write to `/uploads/`
- If Razorpay order creation fails, confirm that cURL is enabled and keys are correct
- If you changed the folder name, update `BASE_URL` in `config.php`
