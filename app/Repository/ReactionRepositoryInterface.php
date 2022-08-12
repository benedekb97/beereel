<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PostInterface;
use App\Entity\ReactionInterface;
use App\Entity\UserInterface;

interface ReactionRepositoryInterface
{
    public function findByUserAndPost(UserInterface $user, PostInterface $post): ?ReactionInterface;
}
