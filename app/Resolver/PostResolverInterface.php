<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Entity\DayInterface;
use App\Entity\PostInterface;
use App\Entity\UserInterface;

interface PostResolverInterface
{
    public function resolve(UserInterface $user): ?PostInterface;
}
