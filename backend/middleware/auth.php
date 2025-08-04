<?php
// backend/middleware/auth.php

$secret_key = 'your_secret_key_here'; // Same as in AuthController

function getBearerToken() {
    $headers = apache_request_headers();
    if (!empty($headers['Authorization'])) {
        if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function validateJWT($token) {
    global $secret_key;
    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return false;
    }

    list($header64, $payload64, $signature64) = $parts;

    $signature = base64_decode(strtr($signature64, '-_', '+/'));
    $data = $header64 . '.' . $payload64;
    $expected_signature = hash_hmac('sha256', $data, $secret_key, true);

    if (!hash_equals($expected_signature, $signature)) {
        return false;
    }

    $payload = json_decode(base64_decode($payload64), true);
    if ($payload['exp'] < time()) {
        return false;
    }

    return $payload;
}

$token = getBearerToken();
if (!$token || !validateJWT($token)) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized']);
    exit;
}