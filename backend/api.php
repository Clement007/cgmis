<?php
session_start();
require_once 'config/db.php';

header('Content-Type: application/json');

$resource = $_GET['resource'] ?? '';
$action = $_GET['action'] ?? '';

switch ($resource) {
    case 'auth':
        require 'controllers/auth.php';
        break;
    case 'student':
        require 'controllers/student.php';
        break;
    case 'session':
        require 'controllers/session.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Resource not found']);
        break;
}