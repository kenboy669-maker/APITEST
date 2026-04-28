<?php
require_once 'core/Database.php';

class News
{
    private $db;

    public function __construct()
    {
        // 透過 Singleton 取得 PDO 連線
        $this->db = Database::getInstance();
    }
    // 取得所有news (GET)
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT title FROM news");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT title,content FROM news WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // 新增news (POST)
    public function create($title, $content)
    {
        $sql = "INSERT INTO news (title, content) VALUES (:title, :content)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    // 更新news (PUT)
    public function update($id, $title, $content)
    {
        $sql = "UPDATE news SET title = :title, content = :content WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // 刪除news (DELETE)
    public function delete($id)
    {
        $sql = "DELETE FROM news WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // GIT
    public function GIT($id)
    {
        $sql = "DELETE FROM news WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
