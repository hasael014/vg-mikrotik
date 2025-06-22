<?php

namespace App;

use App\Helpers\Functions;

class Router
{
    protected static $routes = [];

    public static function get($path, $controller, $method)
    {
        self::addRoute('GET', $path, $controller, $method);
    }

    public static function post($path, $controller, $method)
    {
        self::addRoute('POST', $path, $controller, $method);
    }

    protected static function addRoute($httpMethod, $path, $controller, $method)
    {
        self::$routes[$httpMethod][$path] = [
            "controller" => $controller,
            "method" => $method
        ];
        $_SESSION['rutes'] = [self::$routes];
    }

    protected static function matchRoute($httpMethod, $requestPath)
    {
        if (!isset(self::$routes[$httpMethod])) {
            return [null, null];
        }

        foreach (self::$routes[$httpMethod] as $route => $info) {
            $patt = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $route); // ej. /ruta/web/{id} == /ruta/web/12
            $patt = '#^' . $patt . '$#';

            if (preg_match($patt, $requestPath, $match)) {

                $param = [];

                foreach ($match as $key => $val) {
                    if (is_string($key)) {
                        $param[$key] = $val;
                    }
                }
                return [$info, $param];
            }
        }
        return [null, null];
    }

    public static function App()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        list($routeinfo, $params) = self::matchRoute($method, $path);

        if ($routeinfo) {

            $controller = $routeinfo['controller'];
            $method = $routeinfo['method'];

            try {
                $ctrl = new $controller;

                if (!empty($params)) {
                    // call_user_func_array([$ctrl, $method], $params);
                    $ctrl->$method($params);
                } else {
                    $ctrl->$method();
                }
            } catch (e) {
                // Functions::sendResponse('404');
            }
        }

        // Functions::sendResponse('404');
    }

}