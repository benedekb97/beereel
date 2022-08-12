<?php

declare(strict_types=1);

namespace App\Generator;

use App\Entity\PostInterface;
use App\Entity\Reaction;
use App\Entity\ReactionInterface;
use App\Entity\UserInterface;

class ReactionGenerator implements ReactionGeneratorInterface
{
    public function generate(PostInterface $post, UserInterface $user): ReactionInterface
    {
        $reaction = new Reaction();

        $post->addReaction($reaction);
        $reaction->setUser($user);

        return $reaction;
    }
}
