<?php

$host = 'localhost';
$db_name = 'cgmis';
$username = 'root';  // default WAMP username
$password = '';      // default WAMP password (empty)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}