<?php

namespace Mwl91\Laragen\Generators;

use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\ClassType;
use Mwl91\Laragen\Enums\ClassTypeEnum;
use Mwl91\Laragen\ValueObjects\PhpClass;
use Mwl91\Laragen\Generators\ClassGenerator;
use Mwl91\Laragen\Interfaces\ClassGeneratorInterface;
use Mwl91\Laragen\Interfaces\ServiceGeneratorInterface;

class ServiceGenerator extends ClassGenerator implements ClassGeneratorInterface, ServiceGeneratorInterface
{

    const NAMESPACE_SERVICE = 'App\\Services';
    const NAMESPACE_SERVICE_INTERFACE = 'App\\Services\\Interfaces';

    public function generate(
        string $name,
        array $methodsDefinitions,
        string $serviceNamespaceString = self::NAMESPACE_SERVICE,
        string $serviceInterfaceNamespaceString = self::NAMESPACE_SERVICE_INTERFACE
    ): void {
        $serviceInterface = $this->generateServiceInterface(
            $name,
            $methodsDefinitions,
            $serviceInterfaceNamespaceString
        );

        $serviceClass = $this->generateService(
            $name,
            $serviceInterface,
            $methodsDefinitions,
            $serviceNamespaceString
        );

        echo $serviceInterface->print();
        echo $serviceClass->print();
    }

    public function generateServiceInterface(
        string $name,
        array $methodsDefinitions,
        string $serviceInterfaceNamespaceString = self::NAMESPACE_SERVICE_INTERFACE
    ): PhpClass {
        $interfaceClassName = $this->makeClassName($name, ClassTypeEnum::SERVICE_INTERFACE);

        $file = new PhpFile;
        $namespace = $file->addNamespace($serviceInterfaceNamespaceString);

        $class = new ClassType($interfaceClassName, $namespace);
        $class->setInterface();

        $class->setMethods(
            $this->generateMethodsFromDefinition(
                $methodsDefinitions,
                true
            )
        );

        $namespace->add($class);

        return new PhpClass($file, $class);
    }

    public function generateService(
        string $name,
        PhpClass $interface,
        array $methodsDefinitions,
        string $serviceNamespaceString = self::NAMESPACE_SERVICE
    ): PhpClass {
        $className = $this->makeClassName($name, ClassTypeEnum::SERVICE);

        $file = new PhpFile;
        $namespace = $file->addNamespace($serviceNamespaceString);
        $namespace->addUse($interface->getName());

        $class = new ClassType($className, $namespace);
        $class->addImplement($interface->getName());

        $class->setMethods(
            $this->generateMethodsFromDefinition(
                $methodsDefinitions
            )
        );

        $namespace->add($class);

        return new PhpClass($file, $class);
    }
}
