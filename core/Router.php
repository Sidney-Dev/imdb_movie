<?php

namespace Core;

class Router {
    protected $routes = [];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($uri, $method) {
        $uri = parse_url($uri, PHP_URL_PATH);
        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        [$controller, $method] = explode('@', $action);
        $controller = "App\\Controllers\\$controller";
        call_user_func([new $controller, $method]);
    }
}
