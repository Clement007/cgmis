<?php
session_start();
require_once '../config/db.php';
require_once '../middleware/auth.php';

// Allow only admins with 'Admin' or 'Counselor' roles to manage students
checkRole(['Admin', 'Counselor']);

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        // Get student by ID
        $id = (int)$_GET['id'];
        $sql = "SELECT * FROM students WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows === 1) {
            echo json_encode($result->fetch_assoc());
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Student not found']);
        }
    } else {
        // List all students
        $sql = "SELECT * FROM students ORDER BY created_at DESC";
        $result = $conn->query($sql);
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        echo json_encode($students);
    }
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($_GET['id'])) {
        if (isset($_GET['action']) && $_GET['action'] === 'delete') {
            // Delete student
            $id = (int)$_GET['id'];
            $sql = "DELETE FROM students WHERE id = $id";
            if ($conn->query($sql)) {
                echo json_encode(['message' => 'Student deleted']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to delete student']);
            }
        } else {
            // Update student
            $id = (int)$_GET['id'];
            $first_name = $conn->real_escape_string($data['first_name'] ?? '');
            $last_name = $conn->real_escape_string($data['last_name'] ?? '');
            $email = $conn->real_escape_string($data['email'] ?? '');
            $career_interest = $conn->real_escape_string($data['career_interest'] ?? '');

            $sql = "UPDATE students SET first_name = '$first_name', last_name = '$last_name', email = '$email', career_interest = '$career_interest' WHERE id = $id";
            if ($conn->query($sql)) {
                echo json_encode(['message' => 'Student updated']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update student']);
            }
        }
    } else {
        // Create new student
        $first_name = $conn->real_escape_string($data['first_name'] ?? '');
        $last_name = $conn->real_escape_string($data['last_name'] ?? '');
        $email = $conn->real_escape_string($data['email'] ?? '');
        $career_interest = $conn->real_escape_string($data['career_interest'] ?? '');

        $sql = "INSERT INTO students (first_name, last_name, email, career_interest) VALUES ('$first_name', '$last_name', '$email', '$career_interest')";
        if ($conn->query($sql)) {
            echo json_encode(['message' => 'Student created', 'id' => $conn->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create student']);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}