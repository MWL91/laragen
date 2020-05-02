<?php

namespace Tests\Unit;

use ReflectionMethod;
use Orchestra\Testbench\TestCase;
use Mwl91\Laragen\ValueObjects\MethodDefinition;

class MethodDefinitionTest extends TestCase
{
    /**
     * GenerateScaffold test.
     *
     * @return void
     */
    public function testCreateMethodDefinitionFromExistingClass()
    {
        $methodDefinition = MethodDefinition::instantiateFromExisting(MethodDefinition::class, 'instantiateFromExisting');

        $this->assertEquals('instantiateFromExisting', $methodDefinition->getName());
        $this->assertNotNull($methodDefinition->getBody());
        $this->assertEquals('self', $methodDefinition->getResponse());
        $this->assertCount(2, $methodDefinition->getParameters());
    }
}
