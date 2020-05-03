<?php

namespace Mwl91\Laragen\Generators;

use Nette\PhpGenerator\Method;
use Mwl91\Laragen\ValueObjects\MethodDefinition;

abstract class ClassGenerator
{
    protected function makeClassName(string $name, string $type): string
    {
        return ucfirst($name) . $type;
    }

    protected function generateMethodsFromDefinition(
        array $methodsDefinitions,
        bool $isInterface = false
    ): array {
        $methods = [];

        foreach ($methodsDefinitions as $definition) {
            // declare name and access
            $method = new Method($definition->getName());

            $method->setStatic($definition->isStatic());
            $method->setFinal($definition->isFinal());
            $method->setVisibility($definition->getVisibility());

            // declare parameters
            foreach ($definition->getParameters() as $config) {
                $parameter = $method->addParameter($config->getName());
                $parameter->setType($config->getType());
                $parameter->setNullable($config->getNullable());

                if ($config->getDefaultValue()) {
                    $parameter->setDefaultValue($config->getDefaultValue());
                }
            }

            // declare return type
            $method->setReturnType($definition->getResponse());

            if ($definition->getResponseNullable()) {
                $method->setReturnNullable();
            }

            // set method body
            $body = null;
            if (!$isInterface) {
                $body = $definition->getBody();
            }
            $method->setBody($body);

            $methods[] = $method;
        }

        return $methods;
    }
}
