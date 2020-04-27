<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mwl91\Laragen\Services\LaragenService;

class LaragenServiceTest extends TestCase
{
    /**
     * GenerateScaffold test.
     *
     * @return void
     */
    public function testGenerateScaffold()
    {
        $laragenService = new LaragenService();
        $this->assertNull($laragenService->generateScaffold('example'));
    }
}
