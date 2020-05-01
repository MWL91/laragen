<?php

namespace Mwl91\Laragen\Interfaces;

interface ClassGeneratorInterface
{
    public function generate(string $name, array $methodsDefinitions): void;
}
