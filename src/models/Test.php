<?php
namespace Api\Models;
use Api\Core\Database;
class Test {

    public function __construct() {
        // 透過 Singleton 取得 PDO 連線
        // $this->db = Database::getInstance();
    }

    public function getDefaults() {
        return [
            ['id' => 1, 'name' => 'Defaults Test 1'],
            ['id' => 2, 'name' => 'Defaults Test 2'],
            ['id' => 3, 'name' => 'Defaults Test 3'],
        ];
    }
   
}