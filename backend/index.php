<?php

header('Content-Type: application/json');

echo json_encode([
    'message' => 'Welcome to CGMIS backend API',
    'endpoints' => [
        '/controllers/auth.php',
        '/controllers/student.php',
        '/controllers/session.php'
    ]
]);