<?php
class CounselingSession {
    public $id;
    public $student_id;
    public $counselor_name;
    public $session_date;
    public $notes;
    public $created_at;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}