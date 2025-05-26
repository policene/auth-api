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
    UserController::getByEmail();
} 

elseif ($method === 'POST' && $path === '/token') {
    AuthController::generateToken();
}

elseif ($method === 'GET' && $path === '/token') {
    AuthController::verifyToken();
}

else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found.']);
}

?>