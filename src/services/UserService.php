<?php

require_once __DIR__ . '/../repositories/UserRepository.php';

class UserService {

    public static function createUser($data) {

        if (!isset($data['name']) || !isset($data['lastName']) || !isset($data['email']) || !isset($data['password'])) {
            throw new InvalidArgumentException("All fields must be filled.");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format.");
        }

        if (UserRepository::findByEmail($data['email']) === true) {
            throw new ConflictException("This email is already registered.");
        }

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $user = new User($data['name'], $data['lastName'], $data['email'], $passwordHash);
        UserRepository::saveUser($user);
        return $user->toPublicArray();
    }
}

?>
