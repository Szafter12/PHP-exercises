<?php

namespace App\Core;

class Router
{
    public $routes = [];

    public function get($path, $method)
    {
        $this->addRoute('GET', $path, $method);
    }

    public function post($path, $method)
    {
        $this->addRoute('POST', $path, $method);
    }

    protected function addRoute($method, $path, $action)
    {
        $pathRegex = preg_replace('#\{([^}]+)\}#', '(?P<\1>[^/]+)', $path);
        $pathRegex = "#^" . $pathRegex . "$#";

        $this->routes[$method][] = [
            'path' => $path,
            'regex' => $pathRegex,
            'handler' => $action,
        ];
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = $uri === "/" ? "/" : $uri;

        foreach ($this->routes[$method] ?? [] as $route) {
            if (preg_match($route['regex'], $uri, $matches)) {

                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                if (is_callable($route['handler'])) {
                    return call_user_func($route['handler'], $params);
                } elseif (is_array($route['handler'])) {

                    [$controllerClass, $method] = $route['handler'];

                    $controller = new $controllerClass();

                    return call_user_func([$controller, $method], $params);
                }
            }
        }

        http_response_code(404);
        include __DIR__ . '/Views/404.php';
        return;
    }
}
