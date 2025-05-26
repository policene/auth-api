<?php

require_once __DIR__ . '/../../config/database.php';
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

    public static function existsByEmail (string $email) : bool {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT 1 FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return (bool) $stmt->fetchColumn();
    }

    public static function getByEmail (string $email) : ?User {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT name, last_name, email, password FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new User (
            $row['name'],
            $row['last_name'],
            $row['email'],
            $row['password']
        );

    }

    public static function getById (int $id) : ?User {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT name, last_name, email, password FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new User (
            $row['name'],
            $row['last_name'],
            $row['email'],
            $row['password']
        );

    }

}

?>



