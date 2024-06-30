<?php

namespace App\system;

class Router
{
    private array $routes = [];
    public function addRoute(string $path, array $rules): void
    {
        $this->routes[$path] = $rules;
    }

    public function processRoute(string $url, string $method): void
    {
        $routes = $this->routes;
        if (!$routes) {
            throw new \Exception('Routes not defined');
        }

        $controllerAction = $routes[$url][$method] ?? null;

        if (!$controllerAction) {
            echo 404;
        }

        $this->dispatch($controllerAction);
    }

    private function dispatch(string $controllerAction): void
    {
        [$controller, $action] = explode('@', $controllerAction);
        if (!isset($controller, $action)) {
            throw new \Exception('Invalid route declaration');
        }

        $fileName = CONTROLLERS_DIR . $controller . '.php';
        if(!file_exists($fileName)) {
            throw new \Exception('Controller not found');
        }

        $classname = 'App\controllers\\' . $controller;
        $controllerObject = new $classname();
        $controllerObject->$action();
    }
}