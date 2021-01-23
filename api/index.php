<?php


require 'vendor/autoload.php';

use App\Controllers\JokesController;
use App\Route;
use App\Router;


define('CONTROLLERS_NAMESPACE', 'App\Controllers');

try {

    $request = str_replace('/api/', '', $_SERVER['REQUEST_URI']);

    $router = new Router();

    $router->resolveRoute(new Route('jokes','list'), $request, function ($controller, $action) {
        $controllerName = "${controller}Controller";
        $controllerClass = CONTROLLERS_NAMESPACE . "\\${controllerName}";

        $controller = new ReflectionClass($controllerClass);
        if (!$controller->hasMethod($action)) {
            throw new Exception('No route to api');
        }

        /** @var JokesController $controllerInstance */
        $controllerInstance = $controller->newInstance();
        $action = ucfirst($action);
        $controllerInstance->$action();
        exit;
    });

} catch (\Exception $exception) {
    echo json_encode(array('error' => $exception->getMessage()));
}