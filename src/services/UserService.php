<?php

require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../../config/cache.php';

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

        $cache = new Cache();
        $email = $data['email'];
        $cacheKey = "user:exists:$email";
        $cachedData = $cache->get($cacheKey);
        if ($cachedData === 'true') {
            throw new ConflictException("This email is already registered.");
        }

        if (UserRepository::existsByEmail($email) === true) {
            $cache->set($cacheKey, 'true', 600);
            throw new ConflictException("This email is already registered.");
        }

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $user = new User($data['name'], $data['lastName'], $data['email'], $passwordHash);
        UserRepository::saveUser($user);
        $cache->set($cacheKey, 'true', 600);
        return $user->toPublicArray();
    }


    public static function getByEmail($email) {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format for search.");
        }

        $cache = new Cache();
        $cacheKey = "user:$email";

        $cachedData = $cache->get($cacheKey);
        if ($cachedData) {
             return json_decode($cachedData, true);
        }   

        $user = UserRepository::getByEmail($email);

        if ($user == null) {
            throw new UserNotFoundException("User with email $email not found.");
        }

        $userArray = $user->toPublicArray();
        $cache->set($cacheKey, json_encode($userArray), 600);

        return $userArray;
    }



}

?>
