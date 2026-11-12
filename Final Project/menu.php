<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$catalogFile = __DIR__ . '/data/products.json';
$ordersFile = __DIR__ . '/data/orders.json';

$catalog = json_decode(file_get_contents($catalogFile), true) ?: [];
$selectedCategory = $_GET['category'] ?? 'all';

if ($selectedCategory !== 'all') {
    $catalog = array_values(array_filter($catalog, function ($item) use ($selectedCategory) {
        return ($item['category'] ?? '') === $selectedCategory;
    }));
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'] ?? '';

    foreach ($catalog as $item) {
        if (($item['id'] ?? '') === $productId) {
            $_SESSION['cart'][] = $item;
            break;
        }
    }
}

$cartCount = count($_SESSION['cart']);
$orders = json_decode(file_get_contents($ordersFile), true) ?: [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Cafe Byte</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header class="topbar">
        <div class="brand">Cafe Byte</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="checkout.php">Cart (<?php echo $cartCount; ?>)</a>
            <a href="admin.php">Admin</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="container">
        <section class="hero small-hero">
            <div>
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></h1>
                <p>Explore the menu and add your favorites to the cart.</p>
            </div>
            <div class="status-card">
                <span>Cart Summary</span>
                <strong><?php echo $cartCount; ?> item(s) in cart</strong>
            </div>
        </section>

        <section class="panel">
            <div class="section-heading">
                <div>
                    <h2>Choose a category</h2>
                </div>

                <form method="GET" action="menu.php" class="filter-form">
                    <label for="category">Category</label>
                    <select id="category" name="category" onchange="this.form.submit()">
                        <option value="all" <?php echo $selectedCategory === 'all' ? 'selected' : ''; ?>>All</option>
                        <option value="burger" <?php echo $selectedCategory === 'burger' ? 'selected' : ''; ?>>Burger</option>
                        <option value="pizza" <?php echo $selectedCategory === 'pizza' ? 'selected' : ''; ?>>Pizza</option>
                        <option value="drink" <?php echo $selectedCategory === 'drink' ? 'selected' : ''; ?>>Drink</option>
                        <option value="dessert" <?php echo $selectedCategory === 'dessert' ? 'selected' : ''; ?>>Dessert</option>
                    </select>
                </form>
            </div>

            <div class="product-grid">
                <?php foreach ($catalog as $product): ?>
                    <article class="product-card">
                        <img class="product-image" src="<?php echo htmlspecialchars($product['image'] ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <span class="tag"><?php echo strtoupper(htmlspecialchars($product['category'])); ?></span>
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="price-row">
                            <strong>$<?php echo number_format((float) $product['price'], 2); ?></strong>
                            <small><?php echo htmlspecialchars($product['prep_time']); ?></small>
                        </div>

                        <form method="POST" action="menu.php?category=<?php echo urlencode($selectedCategory); ?>" class="card-form">
                            <input type="hidden" name="add_to_cart" value="1">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <button type="submit" class="primary-btn cart-btn">Add to Cart</button>
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="fetch-demo" class="panel">
            <div class="section-heading">
                <div>
                    <h2>Featured menu</h2>
                </div>
                <button id="loadProducts" class="primary-btn">Load products</button>
            </div>

            <div id="fetchOutput" class="api-output">Tap the button to refresh the featured menu.</div>
        </section>

        <section class="panel">
            <div class="section-heading">
                <div>
                    <h2>Order List</h2>
                </div>
            </div>

            <div class="order-list">
                <?php if (empty($orders)): ?>
                    <p>No orders yet.</p>
                <?php else: ?>
                    <?php foreach (array_slice(array_reverse($orders), 0, 5) as $order): ?>
                        <div class="order-item">
                            <strong><?php echo htmlspecialchars($order['customer_name'] ?? 'Unknown Customer'); ?></strong>
                            <span><?php echo htmlspecialchars($order['customer_email'] ?? 'No email'); ?></span>

                            <ul class="order-item-list">
                                <?php foreach (($order['items'] ?? []) as $item): ?>
                                    <?php $name = htmlspecialchars($item['name'] ?? 'Unknown Item'); ?>
                                    <?php $quantity = (int) ($item['quantity'] ?? 1); ?>
                                    <li><?php echo $name; ?> - Qty: <?php echo $quantity; ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <small><?php echo htmlspecialchars($order['created_at'] ?? 'No order date'); ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script src="assets/app.js"></script>
</body>
</html>
