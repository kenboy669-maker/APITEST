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
    // 新增使用者 (POST)
    public function create($name, $email)
    {
        $sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);

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
