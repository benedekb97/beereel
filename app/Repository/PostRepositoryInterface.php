<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserInterface;

interface PostRepositoryInterface
{
    public function getCurrentPosts(): array;

    public function getPostsForUser(UserInterface $user): array;
}
