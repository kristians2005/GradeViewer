<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "session.php";
require_once "validator.php";
require_once "dataBase.php";
require_once "middleware.php";

$routes = require "routes.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Handle 404
if (!isset($routes[$uri])) {
    header("HTTP/1.0 404 Not Found");
    require "views/404.view.php";
    exit();
}

$route = $routes[$uri];
$controllerAction = $route['controller'];
list($controller, $action) = explode('@', $controllerAction);

// Check role access
if (!empty($route['roles'])) {
    Middleware::checkRole($route['roles']);
}

// Load and execute controller
require_once "controllers/{$controller}.php";
$controllerInstance = new $controller();
$controllerInstance->$action();
