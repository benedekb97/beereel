<?php

declare(strict_types=1);

namespace App\Entity;

interface ReactionInterface extends ResourceInterface
{
    public function getPost(): ?PostInterface;

    public function setPost(?PostInterface $post): void;

    public function getUser(): ?UserInterface;

    public function setUser(?UserInterface $user): void;

    public function getType(): ?ReactionType;

    public function setType(?ReactionType $type): void;
}
