<?php

namespace Mwl91\Laragen\Services;

use Illuminate\Support\Facades\View;
use Mwl91\Laragen\Services\Interfaces\LaragenServiceInterface;

class LaragenService implements LaragenServiceInterface
{
    public function generateScaffold(string $name): string
    {
        return View::make('laragen::controller')->render();
    }
}
