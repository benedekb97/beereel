<?php

declare(strict_types=1);

namespace App\Generator;

use App\Entity\PostInterface;
use App\Entity\ReactionInterface;
use App\Entity\ReactionType;
use App\Entity\UserInterface;

interface ReactionGeneratorInterface
{
    public function generate(PostInterface $post, UserInterface $user): ReactionInterface;
}
