<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Contracts\Auth\Authenticatable;

interface UserInterface extends ResourceInterface, Authenticatable
{
    public function getUsername(): ?string;

    public function setUsername(?string $username): void;

    public function getPassword(): ?string;

    public function setPassword(?string $password): void;

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAtNow(): void;
}
