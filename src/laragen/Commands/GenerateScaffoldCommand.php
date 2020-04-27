<?php

namespace Mwl91\Laragen\Commands;

use Illuminate\Console\Command;
use Mwl91\Laragen\Services\Interfaces\LaragenServiceInterface;

class GenerateScaffoldCommand extends Command
{
    private LaragenServiceInterface $laragenService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:solid-scaffold {name : Name of scaffold}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LaragenServiceInterface $laragenService)
    {
        $this->laragenService = $laragenService;
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
            $this->laragenService->generateScaffold($name);
            $this->info("Scaffolding for \"{$name}\" has been generated! Have fun!");
        } catch (\Exception $e) {
            $this->error("There is an error during scaffolding generate: " . $e->getMessage());
        }
    }
}
