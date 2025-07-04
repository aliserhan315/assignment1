<?php
require("../connection/connection.php");

$query=  "CREATE TABLE IF NOT EXISTS categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
)";
$stmt1 = $mysqli->prepare($query);
$stmt1->execute();
