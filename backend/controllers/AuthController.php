<?php
// backend/controllers/AuthController.php

require_once __DIR__ . '/../models/Admin.php';

class AuthController {
    private $adminModel;
    private $secret_key = 'your_secret_key_here'; // Change this to a strong secret key

    public function __construct($pdo) {
        $this->adminModel = new Admin($pdo);
    }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $admin = $this->adminModel->getByEmail($email);
        if ($admin && password_verify($password, $admin['password'])) {
            $token = $this->generateJWT($admin['id'], $admin['email']);
            echo json_encode(['token' => $token]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }

    private function generateJWT($adminId, $email) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'adminId' => $adminId,
            'email' => $email,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24) // 1 day expiration
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret_key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
}