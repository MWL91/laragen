<?php

namespace Tests\Unit;

use ReflectionMethod;
use Orchestra\Testbench\TestCase;
use Mwl91\Laragen\ValueObjects\MethodDefinition;

class MethodDefinitionTest extends TestCase
{
    public function test_create_MethodDefinition_from_getResponse_method_of_MethodDefinition()
    {
        $methodDefinition = MethodDefinition::instantiateFromExisting(MethodDefinition::class, 'getResponse');

        $this->assertEquals('getResponse', $methodDefinition->getName());
        $this->assertNotNull($methodDefinition->getBody());
        $this->assertEquals('?string', $methodDefinition->getResponse());
        $this->assertCount(0, $methodDefinition->getParameters());
        $this->assertTrue($methodDefinition->getResponseNullable());
        $this->assertStringStartsNotWith('{', trim($methodDefinition->getBody()));
        $this->assertStringEndsNotWith('}', trim($methodDefinition->getBody()));
    }

    public function test_create_MethodDefinition_from_instantiateFromExisting_method_of_MethodDefinition()
    {
        $methodDefinition = MethodDefinition::instantiateFromExisting(MethodDefinition::class, '__construct');

        $this->assertEquals('__construct', $methodDefinition->getName());
        $this->assertNotNull($methodDefinition->getBody());
        $this->assertNull($methodDefinition->getResponse());
        $this->assertCount(4, $methodDefinition->getParameters());
        $this->assertFalse($methodDefinition->getResponseNullable());
        $this->assertStringStartsNotWith('{', trim($methodDefinition->getBody()));
        $this->assertStringEndsNotWith('}', trim($methodDefinition->getBody()));
    }

    public function test_create_MethodDefinition_from_private_of_self()
    {
        $methodDefinition = MethodDefinition::instantiateFromExisting(self::class, 'examplePrivateMethod');
        $this->assertEquals('private', $methodDefinition->getVisibility());
    }

    public function test_create_MethodDefinition_from_protected_of_self()
    {
        $methodDefinition = MethodDefinition::instantiateFromExisting(self::class, 'exampleProtectedMethod');
        $this->assertEquals('protected', $methodDefinition->getVisibility());
    }

    private function examplePrivateMethod(): void
    {
        return;
    }

    protected function exampleProtectedMethod(?int $number): ?int
    {
        return $number;
    }
}
