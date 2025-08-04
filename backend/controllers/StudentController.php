<?php
// backend/controllers/StudentController.php

require_once __DIR__ . '/../models/Student.php';

class StudentController {
    private $studentModel;

    public function __construct($pdo) {
        $this->studentModel = new Student($pdo);
    }

    public function getAll() {
        echo json_encode($this->studentModel->getAll());
    }

    public function getById($id) {
        $student = $this->studentModel->getById($id);
        if ($student) {
            echo json_encode($student);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Student not found']);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->studentModel->create($data)) {
            http_response_code(201);
            echo json_encode(['message' => 'Student created']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to create student']);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->studentModel->update($id, $data)) {
            echo json_encode(['message' => 'Student updated']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to update student']);
        }
    }

    public function delete($id) {
        if ($this->studentModel->delete($id)) {
            echo json_encode(['message' => 'Student deleted']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to delete student']);
        }
    }
}