<?php
session_start();
require_once '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $role = $conn->real_escape_string($data['role'] ?? '');
    $email = $conn->real_escape_string($data['email'] ?? '');
    $password = $data['password'] ?? '';

    if (empty($role) || empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(['error' => 'Role, email, and password are required']);
        exit;
    }

    $sql = "SELECT * FROM admins WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            // Load roles for this admin
            $admin_id = $admin['id'];
            $roles_sql = "SELECT r.role_name FROM roles r
                          JOIN admin_roles ar ON r.id = ar.role_id
                          WHERE ar.admin_id = $admin_id";
            $roles_result = $conn->query($roles_sql);
            $roles = [];
            if ($roles_result) {
                while ($row = $roles_result->fetch_assoc()) {
                    $roles[] = $row['role_name'];
                }
            }

            // Check if requested role is assigned to this admin
            if (!in_array($role, $roles)) {
                http_response_code(403);
                echo json_encode(['error' => 'Access denied for the selected role']);
                exit;
            }

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['roles'] = $roles;

            echo json_encode(['message' => 'Login successful']);
            exit;
        }
    }

    http_response_code(401);
    echo json_encode(['error' => 'Invalid email or password']);
    exit;
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}