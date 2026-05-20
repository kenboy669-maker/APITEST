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

        if (!$user || empty($user['password_hash']) || !password_verify($data['password'], $user['password_hash'])) {
            $this->json(["message" => "Invalid email or password"], 401);
            return;
        }

        $this->respondWithToken($user, "Login successful");
    }

    public function googleLogin()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $idToken = $data['id_token'] ?? $data['credential'] ?? null;
        // var_dump($idToken);
        if (empty($idToken)) {
            $this->json(["message" => "Google id_token is required"], 400);
            return;
        }

        if (GOOGLE_CLIENT_ID !== '501494712724-dquh9309iefpd8f03r0eaakcgpeurq23.apps.googleusercontent.com') {
            $this->json(["message" => "Google Client ID is not configured"], 500);
            return;
        }
        //驗證Google id_token
        $googleUser = $this->verifyGoogleIdToken($idToken);


        if (!$googleUser) {
            return;
        }
        if (($googleUser['aud'] ?? null) !== GOOGLE_CLIENT_ID) {
            $this->json(["message" => "Invalid Google token audience"], 401);
            return;
        }
        if (($googleUser['email_verified'] ?? 'false') !== 'true' && ($googleUser['email_verified'] ?? false) !== true) {
            $this->json(["message" => "Google email is not verified"], 401);
            return;
        }
        if (empty($googleUser['email'])) {
            $this->json(["message" => "Google account email is required"], 401);
            return;
        }
        //google驗證完畢
        //檢查使用者是否存在資料庫，若不存在則建立新使用者 


        $userModel = new User();
        $user = $userModel->findByEmail($googleUser['email']);

        if (!$user) {
            $name = $googleUser['name'] ?? $googleUser['email'];
            // var_dump($googleUser);
            $newUserId = $userModel->create($name, $googleUser['email'], $googleUser['sub']);

            if (!$newUserId) {
                $this->json(["message" => "User creation failed"], 500);
                return;
            }

            $user = $userModel->findById($newUserId);
        }
        // $this->json(json_encode($googleUser));
        // $this->respondWithToken($user, "Google login successful");
        $this->json(["message" => "{$googleUser['name']} welcome! Google login successful"]);
    }

    public function me()
    {
        $payload = $this->requireAuth();

        if (!$payload) {
            return;
        }

        $this->json($payload['user']);
    }
    // 驗證Google id_token
    private function verifyGoogleIdToken($idToken)
    {
        $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken);
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 5,
                'ignore_errors' => true,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);
        // var_dump($response);
        if ($response === false) {
            $this->json(["message" => "Unable to verify Google token"], 502);
            return false;
        }
        $statusCode = 200;
        // var_dump($response);
        if (isset($http_response_header[0]) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $matches)) {
            $statusCode = (int) $matches[1];
        }

        $payload = json_decode($response, true);
        if ($statusCode !== 200 || !is_array($payload)) {
            $this->json(["message" => "Invalid Google token"], 401);
            return false;
        }

        return $payload;
    }

    private function respondWithToken($user, $message)
    {
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
            "message" => $message,
            "token_type" => "Bearer",
            "expires_in" => JWT_TTL,
            "access_token" => Jwt::encode($payload, JWT_SECRET),
        ]);
    }
}
