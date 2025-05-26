<?php

class User {

    private int $id;
    private string $name;
    private string $lastName;
    private string $email;
    private string $password;

    public function __construct($name, $lastName, $email, $password) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId () {
        return $this-> id;
    }

    public function getName () {
        return $this-> name;
    }

    public function getLastName () {
        return $this-> lastName;
    }

    public function getEmail () {
        return $this-> email;
    }

    public function getPassword () {
        return $this-> password;
    }

    public function toPublicArray() {
        return [
            'name' => $this->name,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password
        ];
    }

}

?>