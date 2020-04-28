<?php

namespace Mwl91\Laragen\Generators;

use Nette\PhpGenerator\Printer;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Mwl91\Laragen\Enums\ClassTypeEnum;
use Mwl91\Laragen\Interfaces\GeneratorInterface;
use Mwl91\Laragen\Interfaces\ServiceGeneratorInterface;

class ServiceGenerator extends Generator implements GeneratorInterface, ServiceGeneratorInterface
{
    public function generate(string $name): void
    {
        $namespace = new PhpNamespace('App\\Http\\Controllers');

        $class = new ClassType($this->makeClassName($name, ClassTypeEnum::SERVICE));
        $namespace->add($class);

        $class
            ->addImplement('Countable')
            ->setFinal()
            ->setExtends('ParentClass')
            ->addTrait('Nette\SmartObject')
            ->addComment("Description of class.\nSecond line\n")
            ->addComment('@property-read Nette\Forms\Form $form');

        // or use printer:
        $printer = new Printer;
        echo $printer->printClass($class);
    }
}
