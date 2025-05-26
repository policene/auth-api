<?php

require_once __DIR__ . '/../repositories/UserRepository.php';

class UserService {

    public static function createUser($data) {

        $requiredFields = ['name', 'lastName', 'email', 'password'];
        foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
                throw new InvalidArgumentException("Field '$field' must be filled.");
            }
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format.");
        }

        if (UserRepository::existsByEmail($data['email']) === true) {
            throw new ConflictException("This email is already registered.");
        }

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $user = new User($data['name'], $data['lastName'], $data['email'], $passwordHash);
        UserRepository::saveUser($user);
        return $user->toPublicArray();
    }


    public static function getByEmail($email) {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format for search.");
        }

        $user = UserRepository::getByEmail($email);

        if ($user == null) {
            throw new UserNotFoundException("User with email $email not found.");
        }

        return $user->toPublicArray();
    }



}

?>
