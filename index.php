<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "session.php";
require_once "validator.php";
require_once "dataBase.php";
require_once "middleware.php";

$routes = require "routes.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Function to match dynamic routes
function matchRoute($uri, $routes) {
    foreach ($routes as $route => $config) {
        // Convert route pattern to regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';

        if (preg_match($pattern, $uri, $matches)) {
            // Remove the full match from the beginning
            array_shift($matches);
            
            return [
                'route' => $route,
                'config' => $config,
                'params' => $matches
            ];
        }
    }
    return null;
}

// Try to match the route
$match = matchRoute($uri, $routes);

// Handle 404
if (!$match) {
    header("HTTP/1.0 404 Not Found");
    require "views/404.view.php";
    exit();
}

$route = $match['route'];
$config = $match['config'];
$params = $match['params'];

$controllerAction = $config['controller'];
list($controller, $action) = explode('@', $controllerAction);

// Check role access
if (!empty($config['roles'])) {
    Middleware::checkRole($config['roles']);
}

// Load and execute controller
require_once "controllers/{$controller}.php";
$controllerInstance = new $controller();

// Call the action with parameters if any
if (!empty($params)) {
    call_user_func_array([$controllerInstance, $action], $params);
} else {
    $controllerInstance->$action();
}
