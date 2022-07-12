<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController
{
    public function index(): Factory|View|Application
    {
        return view('welcome');
    }
}
