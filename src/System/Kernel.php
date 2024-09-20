<?php

namespace Peg\System;

use Peg\System\ClassTester;
use Exception;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;

class Kernel
{
    private array $services;
    private array $servicesConfig;

    public function __construct(string $servicesFilePath)
    {
        $this->servicesConfig = Yaml::parseFile($servicesFilePath);;
        $this->services = [];
    }

    public function get(string $class): mixed
    {
        foreach ($this->services as $serviceClass => $service) {
            if (ClassTester::isParentOf($serviceClass, $class)) {
                return $service;
            }
        }

        return $this->instanciate($class);
    }

    private function instanciate(string $paramClass): mixed
    {
        $reflection = new ReflectionClass($paramClass);
        $constructor = $reflection->getConstructor();

        $class = null;

        foreach ($this->servicesConfig as $serviceConfigClass => $serviceConfig) {
            if ($serviceConfigClass === $paramClass) {
                continue;
            }

            if (ClassTester::isParentOf($serviceConfigClass, $paramClass)) {
                $class = $serviceConfigClass;
            }
        }

        if (!$class) {
            throw new Exception($paramClass . " is not mapped as a service.");
        }

        if (!$constructor || count($constructor->getParameters()) === 0) {
            $instance = new $class();
        } else {
            $instanciedParameters = [];
            $parameters = $constructor->getParameters();

            foreach ($parameters as $parameter) {
                $parameterClass = $parameter->getType()->getName();
                $parameterName = $parameter->getName();

                foreach ($this->servicesConfig as $serviceConfigClass => $serviceConfig) {
                    if (ClassTester::isParentOf($serviceConfigClass, $parameterClass) && array_key_exists($parameterName, $this->servicesConfig[$class]['params'])) {
                        $instanciedParameters[$parameterName] = $this->servicesConfig[$class]['params'][$parameterName];
                        continue;
                    }
                }

                if (!array_key_exists($parameterName, $instanciedParameters)) {
                    $instance = $this->get($parameterClass);

                    if (!$instance) {
                        throw new Exception($paramClass . " is not mapped as a service.");
                    }

                    $instanciedParameters[$parameterName] = $instance;
                }
            }

            $instance = new $class(...$instanciedParameters);
        }

        $this->services[$class] = $instance;
        return $instance;
    }
}
