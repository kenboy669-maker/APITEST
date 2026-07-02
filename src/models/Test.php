<?php
namespace Api\Models;

class Test {

    public function __construct() {
        // 這裡可以初始化一些屬性或設定
    }
    //測試改名push
    public function getDefaults() {
        return [
            ['id' => 1, 'name' => 'Defaults Test 1'],
            ['id' => 2, 'name' => 'Defaults Test 2'],
            ['id' => 3, 'name' => 'Defaults Test 3'],
        ];
    }
   
}