<?php 

namespace Peg\System;

use Exception;
use Peg\System\Http\Response;
use ReflectionClass;
use ReflectionMethod;

class ControllerInstancier 
{
    public function __construct(protected Kernel $kernel){}

    public function instanciate(string $class, string $method) : void
    {
        if(!is_subclass_of($class, SystemController::class)){
            throw new Exception($class . " is not a sublass of " . SystemController::class . " .");
        }

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $instanciedParameters = $this->constructFunctionParameters($constructor);

        $controller = new $class(...$instanciedParameters);

        $reflectionMethod = $reflection->getMethod($method);

        if($reflectionMethod){
            $instanciedMethodParameters = $this->constructFunctionParameters($reflectionMethod);
            $response = $controller->$method(...$instanciedMethodParameters);

            if($response && (is_subclass_of($response, Response::class) || $response::class === Response::class)){
                $response->render();
            }
        }else{
            throw new Exception("Method " . $method . " doesn't exists in controller " . $class);
        }
    }

    private function constructFunctionParameters(?ReflectionMethod $method) : array
    {
        $instanciedParameters = [];

        if($method){
            $parameters = $method->getParameters();
            
            foreach($parameters as $parameter){
                $parameterClass = $parameter->getType()->getName();
                $parameterName = $parameter->getName();
                $instanciedParameters[$parameterName] = $this->kernel->get($parameterClass);
            }
        }

        return $instanciedParameters;
    }
}