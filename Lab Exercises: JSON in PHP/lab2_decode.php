<?php
// JSON string
$jsonData = '{"name":"Rodelas, Joyce B.","age":20,"email":"Rodelasjoyce28@gmail.com"}';

// Decode into PHP object
$objectData = json_decode($jsonData);

// Decode into PHP associative array
$arrayData = json_decode($jsonData, true);

// Display expected output
echo "Object: " . $objectData->name . "<br>";
echo "Array: " . $arrayData["email"];
?>
