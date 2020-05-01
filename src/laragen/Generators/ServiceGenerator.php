<?php

namespace Mwl91\Laragen\Generators;

use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\ClassType;
use Mwl91\Laragen\Enums\ClassTypeEnum;
use Mwl91\Laragen\ValueObjects\PhpClass;
use Mwl91\Laragen\Interfaces\ClassGeneratorInterface;
use Mwl91\Laragen\Interfaces\ServiceGeneratorInterface;

class ServiceGenerator extends Generator implements ClassGeneratorInterface, ServiceGeneratorInterface
{
    private string $name;

    public function generate(
        string $name,
        array $methodsDefinitions,
        string $serviceNamespaceString = 'App\\Services',
        string $serviceInterfaceNamespaceString = 'App\\Services\\Interfaces'
    ): void {
        $this->name = $name;

        $serviceInterface = $this->generateServiceInterface($serviceInterfaceNamespaceString);
        $serviceClass = $this->generateService($serviceNamespaceString, $serviceInterface);

        dd($methodsDefinitions, 'inside $methodsDefinitions');

        $method = new Method('count');
        $method->setReturnType('int');
        $method->setReturnNullable();
        $method->setPublic();
        $method->setBody(null);


        $serviceInterface->getClass()->setMethods([$method]);
        echo $serviceInterface->print();

        $method->setBody('return;');


        $serviceClass->getClass()->setMethods([$method]);
        echo $serviceClass->print();
    }

    private function generateServiceInterface(
        string $serviceInterfaceNamespaceString = 'App\\Services\\Interfaces'
    ): PhpClass {
        $interfaceClassName = $this->makeClassName($this->name, ClassTypeEnum::SERVICE_INTERFACE);

        $file = new PhpFile;
        $namespace = $file->addNamespace($serviceInterfaceNamespaceString);

        $class = new ClassType($interfaceClassName, $namespace);
        $class->setInterface();

        $namespace->add($class);

        return new PhpClass($file, $class);
    }

    private function generateService(
        string $serviceNamespaceString = 'App\\Services',
        PhpClass $interface
    ): PhpClass {
        $className = $this->makeClassName($this->name, ClassTypeEnum::SERVICE);

        $file = new PhpFile;
        $namespace = $file->addNamespace($serviceNamespaceString);
        $namespace->addUse($interface->getName());

        $class = new ClassType($className, $namespace);
        $class->addImplement($interface->getName());

        $namespace->add($class);

        return new PhpClass($file, $class);
    }
}
