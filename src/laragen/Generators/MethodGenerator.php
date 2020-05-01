<?php

namespace Mwl91\Laragen\Generators;

use Nette\PhpGenerator\Method;

class MethodGenerator
{
    private string $name;

    public function generate(
        string $name
    ): void {
        $this->name = $name;

        $method = new Method($this->name);
        $method->setReturnType('int');
        $method->setReturnNullable();
        $method->setPublic();
        $method->setBody(null);

        $method->addComment('Count it.');
        $method->addComment('@return int');
        $method->setBody('return count($items ?: $this->items);');
    }
}
