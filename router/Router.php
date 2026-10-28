<?php

namespace public\router;

/*
 * Router simples da aplicação: regista as rotas GET e POST
 * e encaminha cada pedido para o controller e a view correspondentes.
 */
class Router
{
    // Rotas registadas, agrupadas por método: ['GET' => [...], 'POST' => [...]]
    private array $routes = [];

    // Caminho base da aplicação (ex.: /reservaja), adicionado a todas as rotas
    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->appBasePath=$appBasePath;
    }

    // Regista uma rota GET: controller opcional (dados) + view a apresentar
    public function get(string $path, ?array $controller, string $view): void
    {
        $this->routes['GET'][$this->appBasePath.$path] = [
            'controller' => $controller,
            'view' => $view
        ];
    }

    // Regista uma rota POST: apenas o controller que processa a ação
    public function post(string $path, array $controller): void
    {
        $this->routes['POST'][$this->appBasePath.$path] = $controller;
    }

    // Encaminha o pedido atual para a rota registada
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

        // GET: executa o controller (se existir) e apresenta a view com os dados em $dataBase
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

        // POST: executa apenas a ação do controller
        if ($method === 'POST') {
            [$controllerClass, $action] = $route;

            $instance = new $controllerClass($appBasePath);
            $instance->$action();
            return;
        }
    }
}
