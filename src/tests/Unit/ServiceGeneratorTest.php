<?php

namespace Mwl91\Laragen;

use Orchestra\Testbench\TestCase;
use Mwl91\Laragen\Generators\ServiceGenerator;
use Mwl91\Laragen\ValueObjects\MethodDefinition;
use Mwl91\Laragen\ValueObjects\MethodParameter;
use Mwl91\Laragen\ValueObjects\PhpClass;
use Nette\PhpGenerator\Method;

class ServiceGeneratorTest extends TestCase
{

    public function test_generate(): void
    {
        $serviceGenerator = new ServiceGenerator();
        $methodsDefinitions = [$this->makeExampleMethod()];

        $this->assertNull($serviceGenerator->generate('example', $methodsDefinitions));
    }

    public function test_generateServiceInterface(): PhpClass
    {
        $serviceGenerator = new ServiceGenerator();
        $methodsDefinitions = [$this->makeExampleMethod()];

        $phpClass = $serviceGenerator->generateServiceInterface('example', $methodsDefinitions);

        $namespace = ServiceGenerator::NAMESPACE_SERVICE_INTERFACE;
        $method = $phpClass->getClass()->getMethod('sum');
        $parameters = $method->getParameters();

        $this->assertEquals($namespace . '\\ExampleServiceInterface', $phpClass->getName());
        $this->assertContains($namespace, array_keys($phpClass->getFile()->getNamespaces()));
        $this->assertInstanceOf(Method::class, $method);
        $this->assertFalse($method->isStatic());
        $this->assertFalse($method->isFinal());
        $this->assertTrue($method->isReturnNullable());
        $this->assertCount(2, $parameters);
        $this->assertEquals('float', $parameters['a']->getType());
        $this->assertEquals('a', $parameters['a']->getName());
        $this->assertTrue($parameters['a']->isNullable());
        $this->assertNull($method->getBody());

        return $phpClass;
    }

    /**
     * @depends test_generateServiceInterface
     */
    public function test_generateService(PhpClass $interface): void
    {
        $serviceGenerator = new ServiceGenerator();
        $methodsDefinitions = [$this->makeExampleMethod()];

        $phpClass = $serviceGenerator->generateService('example', $interface, $methodsDefinitions);

        $namespace = ServiceGenerator::NAMESPACE_SERVICE;
        $method = $phpClass->getClass()->getMethod('sum');
        $parameters = $method->getParameters();

        $this->assertEquals($namespace . '\\ExampleService', $phpClass->getName());
        $this->assertContains($namespace, array_keys($phpClass->getFile()->getNamespaces()));
        $this->assertInstanceOf(Method::class, $method);
        $this->assertFalse($method->isStatic());
        $this->assertFalse($method->isFinal());
        $this->assertTrue($method->isReturnNullable());
        $this->assertCount(2, $parameters);
        $this->assertEquals('float', $parameters['a']->getType());
        $this->assertEquals('a', $parameters['a']->getName());
        $this->assertTrue($parameters['a']->isNullable());
        $this->assertEquals('return $a + $b;', $method->getBody());
    }

    private function makeExampleMethod(): MethodDefinition
    {
        $methodSum = new MethodDefinition('sum');
        $methodSum->setParameter(new MethodParameter('float', 'a', true, 10));
        $methodSum->setParameter(new MethodParameter('float', 'b'));
        $methodSum->setBody('return $a + $b;');
        $methodSum->setResponse('float');
        $methodSum->setResponseNullable(true);

        return $methodSum;
    }
}
