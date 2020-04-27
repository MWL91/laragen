<?php

namespace Tests\Unit;

use Mwl91\Laragen\LaragenServiceProvider;
use Orchestra\Testbench\TestCase;
use Mwl91\Laragen\Services\LaragenService;

class LaragenServiceTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaragenServiceProvider::class];
    }

    /**
     * GenerateScaffold test.
     *
     * @return void
     */
    public function testGenerateScaffold()
    {
        $laragenService = new LaragenService();
        $this->assertNotNull($laragenService->generateScaffold('example'));
    }
}
