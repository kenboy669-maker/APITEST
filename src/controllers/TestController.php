<?php
namespace Api\Controllers;

use Api\Core\Controller;
use Api\Models\Test;   

class TestController extends Controller
{
    // GET /news
    public function getTest()

    {
        $testModel = new Test();
        $data = $testModel->getDefaults();
        $this->json($data);
    }
}
    