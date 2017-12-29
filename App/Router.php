<?php
namespace App;
class Router
{

    protected $routes;

    public function __construct()
    {
        $routesPath = __DIR__. '/config/routes.php';
        $this->routes = include($routesPath);
    }
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        // Получить строку запроса
        $uri = $this->getURI();
        $i=1;
        // Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path) {
            if($uri==$uriPattern){
                $segments = explode('/', $path);
                $cntrlName = '\\App\\Controllers\\'. ucfirst($segments[0]);
                $action = $segments[1];
                $controller = new $cntrlName;
                try {
                    $controller->action($action);
                } catch (\App\Exceptions\Core $e) {
                    echo 'Возникло исключение приложения: ' . $e->getMessage();
                } catch (PDOException $e) {
                    echo 'Что-то не так с базой';
                }
            }
        }
    }

}
