<?php
class Admin {
    public $id;
    public $name;
    public $email;
    public $password; // hashed password

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}