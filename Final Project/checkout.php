<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_item'])) {
        $index = (int) ($_POST['remove_index'] ?? -1);
        if ($index >= 0 && isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            $message = 'Item removed from cart.';
        }
    }

    if (isset($_POST['place_order'])) {
        $customerName = trim($_POST['customer_name'] ?? '');
        $customerEmail = trim($_POST['customer_email'] ?? '');

    if ($customerName !== '' && $customerEmail !== '' && !empty($_SESSION['cart'])) {
        $ordersFile = __DIR__ . '/data/orders.json';
        $orders = json_decode(file_get_contents($ordersFile), true) ?: [];

        $groupedItems = [];
        foreach ($_SESSION['cart'] as $item) {
            $name = $item['name'] ?? 'Unknown Item';
            if (!isset($groupedItems[$name])) {
                $groupedItems[$name] = [
                    'name' => $name,
                    'quantity' => 0,
                    'price' => $item['price'] ?? 0,
                ];
            }
            $groupedItems[$name]['quantity'] += 1;
        }

        $orders[] = [
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'items' => array_values($groupedItems),
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));
        $_SESSION['cart'] = [];
        $message = 'Your order has been placed successfully.';
        } else {
            $message = 'Please provide your name, email, and add at least one item to cart.';
        }
    }
}

$cartItems = $_SESSION['cart'];
$total = 0;
foreach ($cartItems as $item) {
    $total += (float) ($item['price'] ?? 0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Cafe Byte</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header class="topbar">
        <div class="brand">Cafe Byte</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="checkout.php">Checkout</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="container">
        <section class="panel checkout-panel">
            <div class="section-heading">
                <div>
                    <h2>Checkout</h2>
                </div>
            </div>

            <?php if ($message !== ''): ?>
                <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div class="checkout-layout">
                <div>
                    <h3>Cart Items</h3>
                    <?php if (empty($cartItems)): ?>
                        <p>No items in cart yet.</p>
                    <?php else: ?>
                        <div class="cart-items">
                            <?php foreach ($cartItems as $index => $item): ?>
                                <div class="cart-item">
                                    <div>
                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                                        <span>$<?php echo number_format((float) ($item['price'] ?? 0), 2); ?></span>
                                    </div>

                                    <form method="POST" action="checkout.php" class="remove-item-form">
                                        <input type="hidden" name="remove_item" value="1">
                                        <input type="hidden" name="remove_index" value="<?php echo $index; ?>">
                                        <button type="submit" class="remove-item-btn">Remove</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="total-box">
                        <strong>Total:</strong>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </div>
                </div>

                <form method="POST" action="checkout.php" class="checkout-form">
                    <input type="hidden" name="place_order" value="1">

                    <label>
                        Customer name
                        <input type="text" name="customer_name" placeholder="Juan Dela Cruz" required>
                    </label>

                    <label>
                        Email address
                        <input type="email" name="customer_email" placeholder="juan@email.com" required>
                    </label>

                    <button type="submit" class="primary-btn">Place order</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
