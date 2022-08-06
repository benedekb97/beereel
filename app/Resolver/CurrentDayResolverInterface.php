<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Entity\DayInterface;

interface CurrentDayResolverInterface
{
    public function resolve(): DayInterface;
}
