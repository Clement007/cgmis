<?php
// backend/index.php

$request = $_SERVER['REQUEST_URI'];
$script_name = dirname($_SERVER['SCRIPT_NAME']);
$path = substr($request, strlen($script_name));
$path = strtok($path, '?'); // Remove query string

switch ($path) {
    case '/api/students':
    case '/api/students/':
        require __DIR__ . '/routes/student.php';
        break;
    case (preg_match('#^/api/students/\d+$#', $path) ? true : false):
        require __DIR__ . '/routes/student.php';
        break;
    case '/api/sessions':
    case '/api/sessions/':
        require __DIR__ . '/routes/session.php';
        break;
    case (preg_match('#^/api/sessions/\d+$#', $path) ? true : false):
        require __DIR__ . '/routes/session.php';
        break;
    case '/api/auth/login':
        require __DIR__ . '/routes/auth.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint not found']);
        break;
}