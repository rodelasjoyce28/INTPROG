<?php
header('Content-Type: application/json');

$ordersFile = __DIR__ . '/../data/orders.json';
$catalogFile = __DIR__ . '/../data/products.json';

$rawInput = file_get_contents('php://input');
$data = $rawInput !== '' ? json_decode($rawInput, true) : $_POST;

$customerName = trim((string) ($data['customer_name'] ?? ''));
$customerEmail = trim((string) ($data['customer_email'] ?? ''));
$items = $data['items'] ?? [];

if ($customerName === '' || $customerEmail === '' || empty($items)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Customer name, email, and at least one item are required.'
    ]);
    exit;
}

$catalog = json_decode(file_get_contents($catalogFile), true) ?: [];
$selectedItems = [];

foreach ($items as $productId) {
    foreach ($catalog as $product) {
        if (($product['id'] ?? '') === $productId) {
            $selectedItems[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
            ];
            break;
        }
    }
}

$orders = json_decode(file_get_contents($ordersFile), true) ?: [];
$orders[] = [
    'customer_name' => $customerName,
    'customer_email' => $customerEmail,
    'items' => $selectedItems,
    'created_at' => date('Y-m-d H:i:s'),
];

file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));

echo json_encode([
    'status' => 'success',
    'message' => 'Order saved successfully.',
    'customer_name' => $customerName,
    'items_count' => count($selectedItems),
], JSON_PRETTY_PRINT);
