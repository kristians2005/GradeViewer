<?php
require_once "session.php";
require_once "validator.php";

$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

$routes = require("routes.php");

foreach ($routes as $route => $controller) {
    require_once "controllers/" . explode("@", $controller)[0] . ".php";
}

if (array_key_exists($uri, $routes)) {
    list($controller, $method) = explode('@', $routes[$uri]);
    $instance = new $controller();
    $instance->$method();
    exit();
}

foreach ($routes as $route => $controller) {
    $pattern = preg_replace("#\(:num\)#", "([0-9]+)", $route);
    if (preg_match("#^" . $pattern . "$#", $uri, $matches)) {
        array_shift($matches);
        list($controller, $method) = explode('@', $controller);
        $instance = new $controller();
        $instance->$method(...$matches);
        exit();
    }
}

http_response_code(404);
echo "Lapa nav atrasta!";
exit();
