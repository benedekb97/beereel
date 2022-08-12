<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface PostInterface extends ResourceInterface
{
    public function getUser(): ?UserInterface;

    public function setUser(?UserInterface $user): void;

    public function getDay(): ?DayInterface;

    public function setDay(?DayInterface $day): void;

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAtNow(): void;

    public function getImagePath(): ?string;

    public function setImagePath(?string $imagePath): void;

    public function getFrontImagePath(): ?string;

    public function getBackImagePath(): ?string;

    public function getReactions(): Collection;

    public function hasReaction(ReactionInterface $reaction): bool;

    public function addReaction(ReactionInterface $reaction): void;

    public function removeReaction(ReactionInterface $reaction): void;

    public function getReactionForUser(UserInterface $user): ?ReactionInterface;
}
