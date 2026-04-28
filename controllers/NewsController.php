<?php
require_once 'core/Controller.php';
require_once 'models/News.php';
class NewsController extends Controller
{
    // GET /news
    public function getNews($id = null, $member = null)
    {
        echo "id : " . $id;
        echo "\n";
        echo "member : " . $member;
        echo "\n";
        $newsModel = new News();
        if ($id) {
            $data = $newsModel->getById($id);
        } else {
            $data = $newsModel->getAll();
        }
        $this->json($data);
    }
    // POST /news
    public function createNews()
    {
        // 取得 POST 傳來的 JSON 資料
        //todo : 這裡應該要改成從 $_POST 或是 php://input 來取得資料，因為 POST 的資料不會自動解析到 $_GET
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['title']) && !empty($data['content'])) {
            $NewsModel = new News();
            $id = $NewsModel->create($data['title'], $data['content']);
            if ($id) {
                $this->json(["message" => "News created", "id" => $id], 201);
            } else {
                $this->json(["message" => "Execution failed"], 500);
            }
        } else {
            $this->json(["message" => "Incomplete data"], 400);
        }
    }
    // PUT /news
    public function updateNews()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['title']) && !empty($data['content']) && !empty($data['id'])) {
            $newsModel = new News();
            if ($newsModel->update($data['id'], $data['title'], $data['content'])) {
                $this->json(["message" => "News updated"]);
            } else {
                $this->json(["message" => "Update failed"], 500);
            }
        } else {
            $this->json(["message" => "ID and Name are required"], 400);
        }
    }

    // DELETE /news
    public function deleteNews()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id'])) {
            $newsModel = new News();
            if ($newsModel->delete($data['id'])) {
                $this->json(["message" => "News deleted"]);
            } else {
                $this->json(["message" => "Delete failed"], 500);
            }
        } else {
            $this->json(["message" => "ID is required"], 400);
        }
    }
    //test git
    public function testGit()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id'])) {
            $newsModel = new News();
            if ($newsModel->delete($data['id'])) {
                $this->json(["message" => "News deleted"]);
            } else {
                $this->json(["message" => "Delete failed"], 500);
            }
        } else {
            $this->json(["message" => "ID is required"], 400);
        }
    }
    public function testGi22t()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id'])) {
            $newsModel = new News();
            if ($newsModel->delete($data['id'])) {
                $this->json(["message" => "News deleted"]);
            } else {
                $this->json(["message" => "Delete failed"], 500);
            }
        } else {
            $this->json(["message" => "ID is required"], 400);
        }
    }
}
