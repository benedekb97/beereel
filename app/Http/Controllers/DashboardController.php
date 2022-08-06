<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Resolver\CurrentDayResolver;
use App\Resolver\CurrentDayResolverInterface;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController
{
    private CurrentDayResolverInterface $currentDayResolver;

    public function __construct(
        CurrentDayResolver $currentDayResolver
    )
    {
        $this->currentDayResolver = $currentDayResolver;
    }

    public function index(): Factory|View|Application
    {
        return view('dashboard',
        [
            'day' => $this->currentDayResolver->resolve(),
        ]);
    }
}
