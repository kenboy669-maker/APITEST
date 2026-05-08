<?php
require_once 'config.php';
require_once 'core/Controller.php';
require_once 'core/Jwt.php';
require_once 'models/User.php';

class AuthController extends Controller
{
    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['email']) || empty($data['password'])) {
            $this->json(["message" => "Email and password are required"], 400);
            return;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user['password_hash'])) {
            $this->json(["message" => "Invalid email or password"], 401);
            return;
        }

        $issuedAt = time();
        $expiresAt = $issuedAt + JWT_TTL;
        $payload = [
            'iss' => API_BASE_URL,
            'iat' => $issuedAt,
            'exp' => $expiresAt,
            'user' => [
                'id' => (int) $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ],
        ];

        $this->json([
            "message" => "Login successful",
            "token_type" => "Bearer",
            "expires_in" => JWT_TTL,
            "access_token" => Jwt::encode($payload, JWT_SECRET),
        ]);
    }

    public function me()
    {
        $payload = $this->requireAuth();

        if (!$payload) {
            return;
        }

        $this->json($payload['user']);
    }
}
