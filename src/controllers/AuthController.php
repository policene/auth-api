<?php

require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../exceptions/IncorrectCredentialsException.php';

class AuthController {

    public static function generateToken() {

        $request = json_decode(file_get_contents('php://input'), true);

        try {
            $token = AuthService::generateToken($request);
            http_response_code(200);
            echo json_encode(['token' => $token]);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (IncorrectCredentialsException $e) {
            http_response_code(401);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function verifyToken() {

        $headers = getallheaders();
        $token = str_replace('Bearer ', '', $headers['Authorization'] ?? '');
        $userId = $_GET['id'] ?? null;
        
        try {
            $auth = AuthService::verifyToken($token, $userId);
            http_response_code(200);
            echo json_encode(['auth' => $auth]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }

    }


}

?>