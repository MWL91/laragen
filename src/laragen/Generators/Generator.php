<?php

namespace Mwl91\Laragen\Generators;


abstract class Generator
{
    protected function makeClassName(string $name, string $type): string
    {
        return ucfirst($name) . $type;
    }
}
