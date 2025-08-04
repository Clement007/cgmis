<?php
// backend/controllers/SessionController.php

require_once __DIR__ . '/../models/CounselingSession.php';

class SessionController {
    private $sessionModel;

    public function __construct($pdo) {
        $this->sessionModel = new CounselingSession($pdo);
    }

    public function getAll() {
        echo json_encode($this->sessionModel->getAll());
    }

    public function getById($id) {
        $session = $this->sessionModel->getById($id);
        if ($session) {
            echo json_encode($session);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Session not found']);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->sessionModel->create($data)) {
            http_response_code(201);
            echo json_encode(['message' => 'Session created']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to create session']);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->sessionModel->update($id, $data)) {
            echo json_encode(['message' => 'Session updated']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to update session']);
        }
    }

    public function delete($id) {
        if ($this->sessionModel->delete($id)) {
            echo json_encode(['message' => 'Session deleted']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to delete session']);
        }
    }
}