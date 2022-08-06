<?php

declare(strict_types=1);

namespace App\Generator;

use App\Entity\DayInterface;
use App\Entity\Post;
use App\Entity\PostInterface;
use App\Entity\UserInterface;

class PostGenerator implements PostGeneratorInterface
{
    public function generateForUserAndDay(UserInterface $user, DayInterface $day): PostInterface
    {
        $post = new Post();

        $user->addPost($post);
        $day->addPost($post);

        return $post;
    }
}
