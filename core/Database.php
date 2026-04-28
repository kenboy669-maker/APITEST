<?php

class Database {
    private static $instance = null;
    private $conn;

    // 資料庫設定參數
    private $host = "localhost";
    private $db_name = "newsdb";
    private $username = "RRRD";
    private $password = "RRRB";

    // 私有建構子，防止外部直接 new
    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $exception) {
            // 實際環境應寫入 Log，此處僅簡單回報錯誤
            die("Connection error: " . $exception->getMessage());
        }
    }

    // 取得唯一連線實例
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}