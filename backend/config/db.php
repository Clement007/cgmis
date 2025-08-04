
<?php
// backend/config/db.php

$host = 'localhost';
$dbname = 'cgmis';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Set charset
$conn->set_charset('utf8mb4');
