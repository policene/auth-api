<?php

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/controllers/UserController.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

header('Content-Type: application/json');

if ($method === 'GET' && $path === '/user') {
    $email = $_GET['email'] ?? null;
     if ($email) {
        UserController::getById($email);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Email parameter is required.']);
    }
} 

elseif ($method === 'POST' && $path === '/user') {
    UserController::createUser();
} 

else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found.']);
}



?>