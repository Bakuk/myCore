<?php

namespace Core\src;
use PDO;

class App
{
    private array $routes = [];

    private \Core\src\Container\Container $container;

    public function __construct(\Core\src\Container\Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {
        $pdo = $this->container->get(PDO::class);
        \Core\src\Model\Model::init($pdo);
    }

    public function run()
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri][$requestMethod])) {
            $this->bootstrap();
            $handler = $this->routes[$requestUri][$requestMethod];
            $class = $handler['class'];
            $method = $handler['method'];
            $request = $handler['request'];

            if (empty($request)) {
                $request = new \Core\src\Request\Request($requestMethod, $requestUri, headers_list(), $_REQUEST);
            } else {
                $request = new $request($requestMethod, $requestUri, headers_list(), $_REQUEST);
            }

            $obj = $this->container->get($class);

            try {
                $response = $obj->$method($request);

                if (!empty($response)) {

                    echo $response;

                }

                \Core\src\Logger\LoggerService::info();

            } catch (Throwable $exception) {
                \Core\src\Logger\LoggerService::error($exception);
            }

        } else {
            require_once('./../View/404.html');
        }

    }

    public function getRoutes(string $uri, string $class, string $method, string $request = null)
    {
        $this->routes[$uri]['GET'] = [
            'class' => $class,
            'method' => $method,
            'request' => $request
        ];
    }

    public function postRoutes(string $uri, string $class, string $method, string $request = null)
    {
        $this->routes[$uri]['POST'] = [
            'class' => $class,
            'method' => $method,
            'request' => $request
        ];
    }


}