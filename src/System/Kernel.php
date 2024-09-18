<?php 

namespace Peg\System;

use Exception;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;

class Kernel {
    private array $services;
    private array $servicesConfig;

    public function __construct(string $servicesFilePath){
        $this->servicesConfig = Yaml::parseFile($servicesFilePath);;
        $this->services = [];
    }

    public function get(string $class) : mixed
    {
        if(array_key_exists($class, $this->services)){
            return $this->services[$class];
        }

        return $this->instanciate($class);
    }

    private function instanciate(string $class) : mixed
    {
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if(!$constructor || count($constructor->getParameters()) === 0){
            $instance = new $class();
        }else{
            $instanciedParameters = [];
            $parameters = $constructor->getParameters();
            
            foreach($parameters as $parameter){
                $parameterClass = $parameter->getType()->getName();
                $parameterName = $parameter->getName();
    
                if(array_key_exists($class, $this->servicesConfig) && array_key_exists($parameterName, $this->servicesConfig[$class]['params'])){
                    $instanciedParameters[$parameterName] = $this->servicesConfig[$class]['params'][$parameterName];
                }else{
                    $instanciedParameters[$parameterName] = $this->get($parameterClass);
    
                    if(!$instanciedParameters[$parameterName]){
                        throw new Exception($class . " is not mapped as a service.");
                    }
                }
                
            }
    
            $instance = new $class(...$instanciedParameters);
        }

        $this->services[$class] = $instance;
        return $instance;
    }
}