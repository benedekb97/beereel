<?php

declare(strict_types=1);

namespace App\Generator;

use App\Entity\Day;
use App\Entity\DayInterface;

class DayGenerator implements DayGeneratorInterface
{
    private const DAY_START_MINIMUM = 9;
    private const DAY_START_MAXIMUM = 21;

    public function generate(?\DateTimeInterface $date = null): DayInterface
    {
        $day = new Day();

        $day->setTime($this->generateTime($date));

        return $day;
    }

    private function generateTime(?\DateTimeInterface $date = null): \DateTimeInterface
    {
        $time = sprintf(
            '%s %s:%s:%s',
            isset($date) ? $date->format('Y-m-d') : date('Y-m-d'),
            str_pad((string)rand(self::DAY_START_MINIMUM, self::DAY_START_MAXIMUM), 2, '0', STR_PAD_LEFT),
            str_pad((string)rand(0, 59), 2, '0', STR_PAD_LEFT),
            str_pad((string)rand(0,59), 2, '0', STR_PAD_LEFT)
        );

        return new \DateTime($time);
    }
}
