<?php

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/controllers/UserController.php';
require_once __DIR__ . '/src/controllers/AuthController.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

header('Content-Type: application/json');

if ($method === 'POST' && $path === '/user') {
    UserController::createUser();
} 

elseif ($method === 'GET' && $path === '/user') {
    $email = $_GET['email'] ?? null;
     if ($email) {
        UserController::getByEmail($email);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Email parameter is required.']);
    }
} 

elseif ($method === 'POST' && $path === '/token') {
    AuthController::generateToken();
}

else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found.']);
}

?>