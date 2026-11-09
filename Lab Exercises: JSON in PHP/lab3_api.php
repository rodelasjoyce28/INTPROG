<?php
header('Content-Type: application/json');

$user = array(
    "id" => 1,
    "name" => "Rodelas, Joyce B.",
    "email" => "Rodelasjoyce28@gmail.com",
    "status" => "active"
);

echo json_encode($user);
?>
