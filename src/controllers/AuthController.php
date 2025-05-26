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
        }
    }


}

?>