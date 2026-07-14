<?php

namespace Api\Core;

class Database
{
    private static $instance = null;
    private $conn;

    // 資料庫設定參數
    // PHP 會在這一行告訴你「Constant expression contains invalid operations」
    // 因為 getenv() / config() 是函數，只能在「執行時」調用，不能在「定義時」算值。
    // 正確做法：移到 __construct 或方法中
    // private $host = getenv("DB_HOST") ?: "localhost";
    // private $db_name = getenv("DB_NAME") ?: "newsdb";
    // private $username = getenv("DB_USER") ?: "RRRD";
    // private $password = getenv("DB_PASS") ?: "RRRB";
    private $host;
    private $db_name;
    private $username;
    private $password;

    // 私有建構子，防止外部直接 new
    private function __construct()
    {
        try {
            $this->host = getenv('DB_HOST') ?: "localhost";
            $this->db_name = getenv('DB_NAME') ?: "newsdb";
            $this->username = getenv('DB_USER') ?: "RRRD";
            $this->password = getenv('DB_PASS') ?: "RRRB";
            $this->conn = new \PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (\PDOException $exception) {
            // 實際環境應寫入 Log，此處僅簡單回報錯誤
            die("Connection error: " . $exception->getMessage());
        }
    }

    // 取得唯一連線實例
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
