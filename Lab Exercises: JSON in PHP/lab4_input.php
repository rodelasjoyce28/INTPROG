<?php
// Read incoming JSON data
$jsonData = file_get_contents('php://input');

// Decode JSON data
$data = json_decode($jsonData);

// Display received values
echo "Username: " . $data->username . "<br>";
echo "Password: " . $data->password;
?>
