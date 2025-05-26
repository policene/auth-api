<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository {

    public static function saveUser (User $user) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('INSERT INTO users (name, last_name, email, password) VALUES (:name, :lastName, :email, :password)');
        $stmt->execute([
            'name' => $user->getName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);
    }

    public static function findByEmail (string $email) : bool {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT 1 FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return (bool) $stmt->fetchColumn();
    }

}

?>



