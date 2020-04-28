<?php

namespace Mwl91\Laragen\Generators;

use Illuminate\Support\Facades\View;
use Mwl91\Laragen\Interfaces\GeneratorInterface;
use Mwl91\Laragen\Interfaces\ServiceGeneratorInterface;

class ServiceGenerator implements GeneratorInterface, ServiceGeneratorInterface
{
    public function generate(string $name): string
    {
        $class = new \Nette\PhpGenerator\ClassType('Demo');

        $class
            ->setFinal()
            ->setExtends('ParentClass')
            ->addImplement('Countable')
            ->addTrait('Nette\SmartObject')
            ->addComment("Description of class.\nSecond line\n")
            ->addComment('@property-read Nette\Forms\Form $form');

        // to generate PHP code simply cast to string or use echo:
        echo $class;

        // or use printer:
        $printer = new \Nette\PhpGenerator\Printer;
        echo $printer->printClass($class);

        return View::make('laragen::controller')->render();
    }
}
