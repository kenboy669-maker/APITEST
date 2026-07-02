<?php
namespace Api\Core;
// require_once 'config.php';
// require_once 'core/Jwt.php';
use Api\Core\Jwt;
class Controller
{
    protected function json($data, $status = 200)
    {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($status);
        echo json_encode($data);
    }

    protected function requireAuth()
    {
        $token = Jwt::getBearerToken();

        if (!$token) {
            $this->json(["message" => "Authorization token is required"], 401);
            return false;
        }

        try {
            return Jwt::decode($token, JWT_SECRET);
        } catch (\Exception $exception) {
            $this->json(["message" => $exception->getMessage()], 401);
            return false;
        }
    }
}
