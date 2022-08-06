<?php

declare(strict_types=1);

namespace App\Generator;

use App\Entity\DayInterface;

interface DayGeneratorInterface
{
    public function generate(): DayInterface;
}
