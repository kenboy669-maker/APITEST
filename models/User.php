<?php
require_once 'core/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        // 透過 Singleton 取得 PDO 連線
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT id, name FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT id, name, email, password_hash FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    // 新增使用者 (POST)
    public function create($name, $email, $password = null)
    {
        if ($password) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :password_hash)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $passwordHash);
        } else {
            $sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
        }

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    // 更新使用者 (PUT)
    public function update($id, $name, $email)
    {
        $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // 刪除使用者 (DELETE)
    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // TEST GIT
    public function GIT($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
