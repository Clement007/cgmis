<?php
// backend/routes/session.php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/SessionController.php';
require_once __DIR__ . '/../middleware/auth.php';

$controller = new SessionController($pdo);

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if ($id) {
            $controller->getById($id);
        } else {
            $controller->getAll();
        }
        break;
    case 'POST':
        $controller->create();
        break;
    case 'PUT':
        if ($id) {
            $controller->update($id);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID is required']);
        }
        break;
    case 'DELETE':
        if ($id) {
            $controller->delete($id);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID is required']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}