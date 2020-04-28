<?php

namespace Mwl91\Laragen\Commands;

use Illuminate\Console\Command;
use Mwl91\Laragen\Interfaces\ServiceGeneratorInterface;

class GenerateServiceCommand extends Command
{
    private ServiceGeneratorInterface $generator;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:solid-service {name : Service name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Service generator with interface';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ServiceGeneratorInterface $generator)
    {
        $this->generator = $generator;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $name = $this->argument('name');
            $this->generator->generate($name);
            $this->info("Scaffolding for \"{$name}\" has been generated! Have fun!");
        } catch (\Exception $e) {
            $this->error("There is an error during scaffolding generate: " . $e->getMessage());
        }
    }
}
