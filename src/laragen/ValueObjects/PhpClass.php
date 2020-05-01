<?php

namespace Mwl91\Laragen\ValueObjects;

use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PsrPrinter;

class PhpClass
{

    private PhpFile $file;
    private ClassType $class;

    public function __construct(PhpFile $phpFile, ClassType $class)
    {
        $this->file = $phpFile;
        $this->class = $class;
    }

    /**
     * Get the value of phpFile
     * 
     * @return PhpFile
     */
    public function getFile(): PhpFile
    {
        return $this->file;
    }

    /**
     * Get the value of class
     * 
     * @return ClassType
     */
    public function getClass(): ClassType
    {
        return $this->class;
    }

    /**
     * Get full classname
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->class->getNamespace()->getName() . '\\' . $this->class->getName();
    }

    /**
     * Print class as a string
     *
     * @return string
     */
    public function print(): string
    {
        return (new PsrPrinter)->printFile($this->file);
    }
}
