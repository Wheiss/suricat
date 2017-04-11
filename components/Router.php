<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = Config::$routes;
    }

    private function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run ()
    {
        // Получаем строку запроса
        $uri = $this->getURI();
        
        // Проверка наличия данного запроса в routes.php
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri))
            {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // Определяем контроллер, action, параметры
                $segments = explode('/', $internalRoute);

                $controllerName = ucfirst(array_shift($segments).'Controller');
                $actionName = 'action'.ucfirst(array_shift($segments));

                $parameters = $segments;

                // Подключаем файл класса-контроллера
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                
                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                    // Создаем объект, вызываем метод (action)
                    $controllerObject = new $controllerName;
                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                    if($result !=null) {
                        break;
                    }
                }
            }
        }
    }

}