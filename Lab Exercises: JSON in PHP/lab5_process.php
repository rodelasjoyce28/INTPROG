<?php
header('Content-Type: application/json');

// Receive JSON data
$jsonData = file_get_contents('php://input');

// Decode JSON data
$data = json_decode($jsonData);

// Get the name
$name = $data->name;

// Create JSON response
$response = array(
    "status" => "success",
    "message" => "Welcome, " . $name . "!"
);

// Display JSON response
echo json_encode($response);
?>
