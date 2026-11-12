# Multi-Page PHP Ordering System

This project follows the requested PHP topics and uses them in a simple multi-page ordering system.

## 1. PHP Application

The app is built as a normal PHP website with multiple pages.

- `index.php` = landing page
- `login.php` = displays the login form and starts the user session
- `menu.php` = loads the menu and cart logic
- `checkout.php` = handles the order confirmation form
- `admin.php` = checks and manages customer orders
- `logout.php` = ends the session

This is the main PHP application structure because every page uses PHP to render dynamic content and handle session-based logic.

## 2. PHP GET Method

GET is used for filtering the product list by category.

- File: `menu.php`
- Code usage: `$_GET['category']`
- Purpose: when the user selects a category, the page reloads and shows only the matching items such as burger, pizza, drink, or dessert.

Example:

```php
$selectedCategory = $_GET['category'] ?? 'all';
```

## 3. PHP POST Method

POST is used for sending form data that changes the application state.

- File: `login.php`
  - Code usage: `$_POST['username']` and `$_POST['password']`
  - Purpose: validates the login credentials against the JSON user file.

- File: `checkout.php`
  - Code usage: `$_POST['customer_name']` and `$_POST['customer_email']`
  - Purpose: collects the customer information and saves the new order.

- File: `admin.php`
  - Code usage: `$_POST['update_status']` and `$_POST['delete_order']`
  - Purpose: lets the admin change an order status or remove an order.

## 4. PHP and JSON

JSON is used to store data without a database.

- `data/products.json` = product catalog
- `data/users.json` = user login accounts
- `data/orders.json` = saved customer orders

Example:

```php
$orders = json_decode(file_get_contents($ordersFile), true) ?: [];
file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));
```

This is how the app reads product details, checks login users, and saves orders.

## 5. Fetch API

The Fetch API is used to load product data dynamically from the server.

- File: `api/products.php` = returns the product list in JSON format
- File: `assets/app.js` = runs `fetch()` and displays the returned items

Example:

```js
fetch('api/products.php')
    .then(response => response.json())
    .then(data => { ... });
```

This shows how the frontend can request JSON data without reloading the whole page.

## Pages and flow

- `index.php` - home page
- `login.php` - user login
- `menu.php` - browse and filter products
- `checkout.php` - confirm and place order
- `admin.php` - view orders and update/remove them

## Run the project

```bash
php -S localhost:8000
```

Then open:

```text
http://localhost:8000/
```

## Demo login

- Username: `admin`
- Password: `admin123`

or

- Username: `customer`
- Password: `customer123`
