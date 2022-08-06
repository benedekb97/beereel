<?php

declare(strict_types=1);

namespace App\Generator;

use App\Entity\DayInterface;
use App\Entity\PostInterface;
use App\Entity\UserInterface;

interface PostGeneratorInterface
{
    public function generateForUserAndDay(UserInterface $user, DayInterface $day): PostInterface;
}
