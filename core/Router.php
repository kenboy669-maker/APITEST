<?php
class Router
{
    private $routes = [];

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
             *  由於比對字串中有包含斜杠所以使用 '#xxxx#'作為開頭與結尾 與'/xxxx/' 意思相同*/
            /** $matches: 如果提供了参数matches，它将被填充为搜索结果。 $matches[0]将包含完整模式匹配到的文本， $matches[1] 将包含第一个捕获子组匹配到的文本，以此类推。 */
            if (preg_match($pattern, $path, $matches)) {
                /**array_shift() 函数用于删除数组中的第一个元素，并直截存回被删除的元素。(不用設變數去接) */
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
