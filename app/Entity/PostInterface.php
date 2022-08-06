<?php

declare(strict_types=1);

namespace App\Entity;

interface PostInterface extends ResourceInterface
{
    public function getUser(): ?UserInterface;

    public function setUser(?UserInterface $user): void;

    public function getDay(): ?DayInterface;

    public function setDay(?DayInterface $day): void;

    public function getImagePath(): ?string;

    public function setImagePath(?string $imagePath): void;
}
