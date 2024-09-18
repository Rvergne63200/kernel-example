<?php

use Peg\System\ControllerInstancier;
use Peg\System\Kernel;
use Peg\System\Router;

require_once __DIR__.'/vendor/autoload.php';

$kernel = new Kernel(__DIR__ . "/config/services.yaml");
$controllerInstancier = new ControllerInstancier($kernel);

$router = new Router(__DIR__ . "/config/routes.yaml", $controllerInstancier);
$route = array_key_exists("PATH_INFO", $_SERVER) ? $_SERVER['PATH_INFO'] : "/" ;

try{
    $router->execute($route);
}catch(Exception $e){
    echo $e->getMessage();
}
