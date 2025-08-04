<?php
class Student {
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $career_interest;
    public $created_at;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}