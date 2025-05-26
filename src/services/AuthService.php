<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;

class AuthService {

    public static function generateToken ($credentials) {

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $secret = $_ENV['JWT_SECRET'];

        $requiredFields = ['email', 'password'];
        foreach ($requiredFields as $field) {
        if (!isset($credentials[$field]) || trim($credentials[$field]) === '') {
                throw new InvalidArgumentException("Field '$field' must be filled.");
            }
        }

        $email = $credentials['email'];
        $password = $credentials['password'];

        $user = UserRepository::getByEmail($email);

        if ($user == null) {
            throw new IncorrectCredentialsException('Incorrect credentials.');
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new IncorrectCredentialsException('Incorrect credentials.');
        }

        $payload = [
            'email' => $user->getEmail(),
            'iat' => time(),
            'exp' => time() + 3600 
        ];

        $token = JWT::encode($payload, $secret, 'HS256');

        return $token;




    }

}

?>