<?php
// backend/models/CounselingSession.php

class CounselingSession {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT cs.*, s.first_name, s.last_name FROM counseling_sessions cs JOIN students s ON cs.student_id = s.id ORDER BY cs.session_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM counseling_sessions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO counseling_sessions (student_id, counselor_name, session_date, notes) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['student_id'],
            $data['counselor_name'],
            $data['session_date'],
            $data['notes']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE counseling_sessions SET student_id = ?, counselor_name = ?, session_date = ?, notes = ? WHERE id = ?");
        return $stmt->execute([
            $data['student_id'],
            $data['counselor_name'],
            $data['session_date'],
            $data['notes'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM counseling_sessions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}