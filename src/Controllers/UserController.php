<?php
namespace Api\Controllers;

// require_once 'core/Controller.php';
// require_once 'models/User.php';
use Api\Core\Controller;
use Api\Models\User;   

class UserController extends Controller
{
    public function getUsersTest()
    {
        $users = [["id" => 1, "name" => "John Doe"]];
        $this->json($users);
    }
    // GET /users
    public function getUsers()
    {
        $userModel = new User();
        $data = $userModel->getAll();

        $this->json($data);
    }
    // POST /users
    public function createUser()
    {
        // 取得 POST 傳來的 JSON 資料
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['name']) && !empty($data['email'])) {
            $userModel = new User();
            $id = $userModel->create($data['name'], $data['email'], $data['google_id'] ?? null, $data['password'] ?? null);

            if ($id) {
                $this->json(["message" => "User created", "id" => $id], 201);
            } else {
                $this->json(["message" => "Execution failed"], 500);
            }
        } else {
            $this->json(["message" => "Incomplete data"], 400);
        }
    }
    // PUT /users
    public function updateUser()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id']) && !empty($data['name'])) {
            $userModel = new User();
            if ($userModel->update($data['id'], $data['name'], $data['email'])) {
                $this->json(["message" => "User updated"]);
            } else {
                $this->json(["message" => "Update failed"], 500);
            }
        } else {
            $this->json(["message" => "ID and Name are required"], 400);
        }
    }

    // DELETE /users
    public function deleteUser()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id'])) {
            $userModel = new User();
            if ($userModel->delete($data['id'])) {
                $this->json(["message" => "User deleted"]);
            } else {
                $this->json(["message" => "Delete failed"], 500);
            }
        } else {
            $this->json(["message" => "ID is required"], 400);
        }
    }
}
