<?php

namespace Peg\System;

use Exception;
use Symfony\Component\Yaml\Yaml;

class Router 
{
    protected array $routes;
    
    public function __construct(string $routesFilePath, protected ControllerInstancier $controllerInstancier)
    {   
        $this->routes = Yaml::parseFile($routesFilePath);
    }

    public function execute(string $route){
        if(!array_key_exists($route, $this->routes)){
            throw new Exception($route . " route doesn't exists");
            die();
        }

        $routeData = $this->routes[$route];

        $controllerClass = explode('::', $routeData['controller'])[0];
        $controllerMethod = explode('::', $routeData['controller'])[1];

        $this->controllerInstancier->instanciate($controllerClass, $controllerMethod);
    }
}