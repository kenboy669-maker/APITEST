<?php
class Router
{
    private $routes = [];

    /**
     * 用來註冊路由，接受HTTP方法、路徑和處理程序作為參數，並將它們存儲在 $routes 屬性中。
     * @param mixed $method
     * @param mixed $path
     * @param mixed $handler
     * @return void
     */
    public function add($method, $path, $handler)
    {
        $this->routes[] = ['method' => $method, 'path' => $path, 'handler' => $handler];
    }
    public function dispatchErrorVer($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                list($controller, $action) = explode('@', $route['handler']);
                require_once "controllers/$controller.php";
                $ctrl = new $controller();
                $ctrl->$action();
                return;
            }
        }
        http_response_code(404);
        echo json_encode(["message" => "Route not found"]);
    }
    // 
    /** 
     * dispatch 方法負責處理傳入的 HTTP 請求，根據請求的 URI 和方法來匹配註冊的路由，並調用相應的控制器和方法來處理請求。
     * @param mixed $path
     * @param mixed $method
     * @return void
     */
    public function dispatch($path, $method)
    {
        $method = strtoupper($method);
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            $pattern = preg_replace('/\{[a-zA-Z_][a-zA-Z0-9_]*\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';
            /** #^/php/api/news/([^/]+)$# 
             * ^ 表示字符串的开始，$ 表示字符串的结束，([^/]+) 是一个捕获组，匹配一个或多个非斜杠字符，这样就可以捕获路径中的动态部分（如 {id}）。 
             *  由於比對字串中有包含斜杠所以使用 '#xxxx#'作為開頭與結尾 與'/xxxx/' 意思相同
             */
            
            /** preg_match(模式,字串,匹配) 正則表達搜尋function， 如果提供了参數matches，將填充为搜索结果。 $matches[0]將包含完整模式抓到的文本， $matches[1] 第一個抓到的，以此類推。 */
            if (preg_match($pattern, $path, $matches)) {
                /**array_shift() 删除array中的第一個元素，並直接存回被刪除的元素。(不用設變數去接) */
                array_shift($matches);
                list($controllerName, $action) = explode('@', $route['handler']);
                require_once "controllers/{$controllerName}.php";
                $controller = new $controllerName();
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }
        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
    }
}
