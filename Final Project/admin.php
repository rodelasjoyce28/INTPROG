<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$ordersFile = __DIR__ . '/data/orders.json';
$orders = json_decode(file_get_contents($ordersFile), true) ?: [];
$allowedStatuses = ['Pending', 'Preparing', 'Ready', 'Completed', 'Cancelled'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_order'])) {
        $index = (int) ($_POST['delete_order'] ?? -1);
        if ($index >= 0 && isset($orders[$index])) {
            unset($orders[$index]);
            $orders = array_values($orders);
            file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));
        }
    }

    if (isset($_POST['update_status'])) {
        $index = (int) ($_POST['update_status'] ?? -1);
        if ($index >= 0 && isset($orders[$index])) {
            $status = trim((string) ($_POST['status'] ?? 'Pending'));
            if (in_array($status, $allowedStatuses, true)) {
                $orders[$index]['status'] = $status;
                file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));
            }
        }
    }
}

$orders = array_reverse($orders);

function summarizeOrderItems($items): array
{
    $grouped = [];

    foreach ($items as $item) {
        $name = trim((string) ($item['name'] ?? 'Unknown Item'));
        if ($name === '') {
            continue;
        }

        if (!isset($grouped[$name])) {
            $grouped[$name] = [
                'name' => $name,
                'quantity' => 0,
            ];
        }

        $grouped[$name]['quantity'] += (int) ($item['quantity'] ?? 1);
    }

    return array_values($grouped);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders | Cafe Byte</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header class="topbar">
        <div class="brand">Cafe Byte</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="checkout.php">Checkout</a>
            <a href="admin.php">Admin</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="container">
        <section class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Admin</p>
                    <h2>Order Management</h2>
                </div>
            </div>

            <div class="admin-order-list">
                <?php if (empty($orders)): ?>
                    <p>No orders yet.</p>
                <?php else: ?>
                    <?php foreach ($orders as $index => $order): ?>
                        <?php $groupedItems = summarizeOrderItems($order['items'] ?? []); ?>
                        <?php $status = $order['status'] ?? 'Pending'; ?>
                        <div class="admin-order-card">
                            <div class="admin-order-head">
                                <div>
                                    <strong><?php echo htmlspecialchars($order['customer_name'] ?? 'Unknown Customer'); ?></strong>
                                    <span><?php echo htmlspecialchars($order['customer_email'] ?? 'No email'); ?></span>
                                </div>
                                <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $status)); ?>"><?php echo htmlspecialchars($status); ?></span>
                            </div>

                            <ul class="order-item-list">
                                <?php foreach ($groupedItems as $item): ?>
                                    <li>
                                        <?php echo htmlspecialchars($item['name']); ?> - Qty: <?php echo (int) $item['quantity']; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <small><?php echo htmlspecialchars($order['created_at'] ?? 'No order date'); ?></small>

                            <form method="POST" action="admin.php" class="admin-order-form">
                                <input type="hidden" name="update_status" value="<?php echo $index; ?>">

                                <label>
                                    Order status
                                    <select name="status">
                                        <?php foreach ($allowedStatuses as $value): ?>
                                            <option value="<?php echo htmlspecialchars($value); ?>" <?php echo $status === $value ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($value); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>

                                <div class="admin-actions">
                                    <button type="submit" class="primary-btn">Update status</button>
                                </div>
                            </form>

                            <form method="POST" action="admin.php" class="inline-form">
                                <input type="hidden" name="delete_order" value="<?php echo $index; ?>">
                                <button type="submit" class="danger-btn" onclick="return confirm('Remove this order?');">Remove</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
