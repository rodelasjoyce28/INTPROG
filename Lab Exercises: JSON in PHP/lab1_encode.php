<?php
// Declare an associative array
$student = array(
    "name" => "Rodelas, Joyce B.",
    "age" => 20,
    "course" => "BSIT"
);

// Convert PHP array into JSON format
$jsonData = json_encode($student);

// Display the JSON output
echo $jsonData;
?>
