<?php
header('Content-Type: application/json');

$productFile = __DIR__ . '/../data/products.json';
$catalog = json_decode(file_get_contents($productFile), true) ?: [];
$category = $_GET['category'] ?? 'all';

if ($category !== 'all') {
    $catalog = array_values(array_filter($catalog, function ($item) use ($category) {
        return ($item['category'] ?? '') === $category;
    }));
}

echo json_encode([
    'category' => $category,
    'products' => $catalog,
], JSON_PRETTY_PRINT);
