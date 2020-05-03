<?php

namespace Mwl91\Laragen\Commands;

use Mwl91\Laragen\Commands\GeneratorCommand;
use Mwl91\Laragen\Interfaces\ServiceGeneratorInterface;

class GenerateServiceCommand extends GeneratorCommand
{

    const SUCCESS = "Scaffolding for \":name\" has been generated! Have fun!";
    const ERROR = "There is an error during class generation: ";

    private ServiceGeneratorInterface $generator;

    protected $signature = 'generate:solid-service {name : Service name}';
    protected $description = 'Service generator with interface';

    public function __construct(ServiceGeneratorInterface $generator)
    {
        $this->generator = $generator;
        parent::__construct();
    }

    public function handle()
    {
        try {
            $name = $this->argument('name');

            $this->generator->generate($name, $this->getMethodsDefinitionInput());
            $this->info(str_replace(':name', $name, self::SUCCESS));
        } catch (\Exception $e) {
            $this->error(self::ERROR . $e->getMessage());
        }
    }
}
