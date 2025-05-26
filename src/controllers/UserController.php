<?php

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../exceptions/ConflictException.php';
require_once __DIR__ . '/../exceptions/UserNotFoundException.php';

class UserController {

    public static function createUser() {
        $request = json_decode(file_get_contents('php://input'), true);

        try {
            $response = UserService::createUser($request);
            http_response_code(201);
            echo json_encode([
                'msg' => 'ok',
                'user' => $response
            ]);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (ConflictException $e) {
            http_response_code(409);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } 

    public static function getByEmail($email) {

        try {
            $response = UserService::getByEmail($email);
            http_response_code(200);
            echo json_encode($response);
        } catch (Exception $e) {
            http_response_code(404);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}

?>
