<?php

namespace public\router;

class Router
{
    private array $routes = [];

    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->appBasePath=$appBasePath;
    }

    public function get(string $path, ?array $controller, string $view): void
    {
        $this->routes['GET'][$this->appBasePath.$path] = [
            'controller' => $controller,
            'view' => $view
        ];
    }

    public function post(string $path, array $controller): void
    {
        $this->routes['POST'][$this->appBasePath.$path] = $controller;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $appBasePath= $this->appBasePath;


        //pagina inicial
        if ($method === 'GET' && $path === $this->appBasePath.'/') {
            header("Location:".$this->appBasePath."/html/client/home.php");
            exit();
        }

        //pagina 404
        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            require __DIR__ . '/../html/404.php';
            exit();
        }

        $route = $this->routes[$method][$path];

        if ($method === 'GET') {
            $controller = $route['controller'];
            $view = $route['view'];

            $data = [];

            if ($controller !== null) {
                [$controllerClass, $action] = $controller;

                $instance = new $controllerClass($appBasePath);
                $dataBase = $instance->$action();
            }

            require $view;
            return;
        }

        if ($method === 'POST') {
            [$controllerClass, $action] = $route;

            $instance = new $controllerClass($appBasePath);
            $instance->$action();
            return;
        }
    }
}
