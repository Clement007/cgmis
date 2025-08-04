<?php
session_start();
require_once '../config/db.php';
require_once '../middleware/auth.php';

// Allow only admins with 'Admin' or 'Counselor' roles to manage sessions
checkRole(['Admin', 'Counselor']);

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        // Get session by ID
        $id = (int)$_GET['id'];
        $sql = "SELECT * FROM counseling_sessions WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows === 1) {
            echo json_encode($result->fetch_assoc());
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Session not found']);
        }
    } else {
        // List all sessions
        $sql = "SELECT * FROM counseling_sessions ORDER BY session_date DESC";
        $result = $conn->query($sql);
        $sessions = [];
        while ($row = $result->fetch_assoc()) {
            $sessions[] = $row;
        }
        echo json_encode($sessions);
    }
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($_GET['id'])) {
        if (isset($_GET['action']) && $_GET['action'] === 'delete') {
            // Delete session
            $id = (int)$_GET['id'];
            $sql = "DELETE FROM counseling_sessions WHERE id = $id";
            if ($conn->query($sql)) {
                echo json_encode(['message' => 'Session deleted']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to delete session']);
            }
        } else {
            // Update session
            $id = (int)$_GET['id'];
            $student_id = (int)($data['student_id'] ?? 0);
            $counselor_name = $conn->real_escape_string($data['counselor_name'] ?? '');
            $session_date = $conn->real_escape_string($data['session_date'] ?? '');
            $notes = $conn->real_escape_string($data['notes'] ?? '');

            $sql = "UPDATE counseling_sessions SET student_id = $student_id, counselor_name = '$counselor_name', session_date = '$session_date', notes = '$notes' WHERE id = $id";
            if ($conn->query($sql)) {
                echo json_encode(['message' => 'Session updated']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update session']);
            }
        }
    } else {
        // Create new session
        $student_id = (int)($data['student_id'] ?? 0);
        $counselor_name = $conn->real_escape_string($data['counselor_name'] ?? '');
        $session_date = $conn->real_escape_string($data['session_date'] ?? '');
        $notes = $conn->real_escape_string($data['notes'] ?? '');

        $sql = "INSERT INTO counseling_sessions (student_id, counselor_name, session_date, notes) VALUES ($student_id, '$counselor_name', '$session_date', '$notes')";
        if ($conn->query($sql)) {
            echo json_encode(['message' => 'Session created', 'id' => $conn->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create session']);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}