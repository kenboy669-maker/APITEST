<?php
require_once 'core/Controller.php';
require_once 'models/News.php';
class NewsController extends Controller
{
    // GET /news
    public function getNews($id = null, $member = null)
    {
        echo "id : " . $id . "\n";
        echo "member : " . $member . "\n";
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
    // /UploadFile
    public function uploadFile()
    {
        if (!isset($_FILES['file'])) {
            $this->json(["message" => "No file uploaded"], 400);
            return;
        }

        $file = $_FILES['file'];

        if (is_array($file['error'])) {
            $this->json(["message" => "Invalid upload parameters"], 400);
            return;
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->json(["message" => "No file sent"], 400);
                return;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $this->json(["message" => "Exceeded filesize limit"], 400);
                return;
            default:
                $this->json(["message" => "Unknown upload error"], 500);
                return;
        }

        if ($file['size'] <= 0) {
            $this->json(["message" => "Empty file"], 400);
            return;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $allowedTypes = [
            'gif' => 'image/gif'
        ];

        $ext = array_search($mimeType, $allowedTypes, true);

        if ($ext === false) {
            $this->json([
                "message" => "Only GIF files are allowed",
                "mime" => $mimeType
            ], 400);
            return;
        }

        $uploadDir = __DIR__ . '/../uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newFileName = uniqid('gif_', true) . '.' . $ext;
        $filePath = $uploadDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $this->json([
                "message" => "File uploaded successfully",
                "filename" => $newFileName,
                "path" => "uploads/" . $newFileName
            ]);
        } else {
            $this->json(["message" => "File upload failed"], 500);
        }
    }
    public function uploadTest()
    {
        echo "Upload Test\n";
        if (!isset($_FILES['file'])) {
            $this->json(["message" => "No file uploaded"], 400);
            return;
        }
        $file = $_FILES['file'];
        if (is_array($file['error'])) {
            $this->json(["message" => "Invalid upload parameters"], 400);
            return;
        }
        // 1. 使用絕對路徑定義資料夾 (指向網站根目錄下的 upload)
        $uploadDir = API_BASE_PATH . 'upload/'; // 假設 Controller 在 controllers/，目錄在根目錄

        // 2. 如果資料夾不存在，自動建立它
        if (!is_dir($uploadDir)) {
            /**權限0777 任何人（所有者、群組、其他用戶）代表讀+寫+執(rwx)(4+2+1)。*/
            /** mkdir(資料夾路徑, 權限 0777, 是否建立多層目錄) */
            if (!mkdir($uploadDir, 0777, true)) {
                echo "無法建立 upload 資料夾\n";
                return;
            }
        }
        //如果檔案大於5mb禁止上傳
        else if ($file['size'] > 5 * 1024 * 1024) {
            echo '檔案過大，禁止上傳。\n';
        }
        //如果檔案不屬於圖片檔，禁止上傳
        else if (!getimagesize($file['tmp_name'])) {
            echo '只能上傳圖片檔案。\n';
        } else {
            // var_dump(getimagesize($file['tmp_name']));
            // 將檔名改成時間戳，避免重複檔名造成的衝突
            $file['name'] = time() . '_' . $file['name'];
            $dest =  $uploadDir .  $file['name'];
            var_dump($file);
            echo $file['name'] . "\n" . $dest . "\n";
            /** 將暫存檔案移至指定位置 */
            /**
             * 如果在程式裡面做過多的運算或處理
             * 導致 Request 超時（max_execution_time）
             * 檔案還沒搬完就中斷，那這個檔案就會因為腳本結束而被伺服器自動清掉
             * 所以上傳大檔案時必須確保 
             * PHP 的 max_execution_time 和 upload_max_filesize 都足夠大
             */
            move_uploaded_file($file['tmp_name'], $dest);
            echo "檔案上傳成功。\n";
        }
    }
}
