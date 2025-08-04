<?php
// backend/routes/auth.php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$controller = new AuthController($pdo);

$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

if ($method === 'POST') {
    $controller->login();
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}