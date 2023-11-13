<?php

class App {
    protected $controllerName;
    protected $methodName;
    protected $params = [];

    public function __construct() {
        $url = $this->splitURL();

        $controllerName = array_shift($url) ?? 'Home';
        $methodName = array_shift($url) ?? 'index';
        $params = $url;

        $controllerName = ucfirst($controllerName);
        
        $c = ucfirst($controllerName). "Controller";
    
        if (file_exists("./controller/" .$c . ".php")) {
            require_once("./controller/" .$c . ".php");
        }

        $app = new $c();
        $app->$methodName(...$params);
    }

    public function splitURL() {
        // $pathinfo = $_SERVER['PATH_INFO'] ?? "";
        $pathinfo = $_SERVER['REQUEST_URI'];

        $pathinfo = str_replace('?', '/', $pathinfo);
        $path = explode("/", $pathinfo);
        
        array_shift($path);
        array_shift($path);
        array_shift($path);
        
        return $path;
    }
}