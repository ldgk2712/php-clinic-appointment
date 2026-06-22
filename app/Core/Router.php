<?php

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        if (isset($this->routes[$method][$path])) {
            [$controller, $action] = $this->routes[$method][$path];
            (new $controller())->$action();
            return;
        }

        $allowedMethods = [];
        foreach ($this->routes as $registeredMethod => $methodRoutes) {
            if (isset($methodRoutes[$path])) {
                $allowedMethods[] = $registeredMethod;
            }
        }

        if ($allowedMethods !== []) {
            header('Allow: ' . implode(', ', $allowedMethods));
            http_response_code(405);
            render('errors/405', [
                'allowedMethods' => $allowedMethods,
            ], '405 Method Not Allowed');
            return;
        }

        http_response_code(404);
        render('errors/404', [], '404 Not Found');
    }
}
