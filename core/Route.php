<?php

    class Route {

        public static function parseUrl() {
            $ca_values = self::getControllerAndAction(); //получаем имена контроллера и экшена
            $controller = $ca_values[0]."Controller";
            $action = $ca_values[1]."Action";

            if(class_exists($controller)) $controller = new $controller();
            if(method_exists($controller, $action)) $controller->$action();
            else $controller->action404();
        }

        private static function getControllerAndAction() {
            $uri = $_SERVER["REQUEST_URI"];
            if($pos = strpos($uri, '?')) $uri = substr($uri, 0, $pos);

            $controller = "Index";
            $action = "index";

            $routes = explode("/", $uri);
            if(!empty($routes[2])){
                if(!empty($routes[1])) $controller = strtoupper(substr($routes[1], 0, 1)).substr($routes[1], 1);
                $action = $routes[2];
            }
            elseif(!empty($routes[1])) $action = $routes[1];
            return [$controller, $action];
        }
    }

?>