<?php


namespace App;


class Router {

    public function resolveRoute(Route $route ,string $uri, callable $callback): void {
        $path = $route->getController() . '/' . $route->getAction();

        if (strpos($uri, $path) === false) {
            return;
        }

        $controller = $route->getController();
        $action = $route->getAction();

        $callback($controller, $action);
    }

    private function removeGetParams(string $uri): string {
        return explode('?', $uri)[0];
    }

}