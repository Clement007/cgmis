<?php
session_start();

function checkRole(array $requiredRoles) {
    if (!isset($_SESSION['admin_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
    if (!isset($_SESSION['roles'])) {
        http_response_code(403);
        echo json_encode(['error' => 'No roles assigned']);
        exit;
    }
    $userRoles = $_SESSION['roles'];
    foreach ($requiredRoles as $role) {
        if (in_array($role, $userRoles)) {
            return; // Authorized
        }
    }
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden: insufficient permissions']);
    exit;
}