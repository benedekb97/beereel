<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Illuminate\Contracts\Auth\Authenticatable;

interface UserInterface extends ResourceInterface, Authenticatable
{
    public function getUsername(): ?string;

    public function setUsername(?string $username): void;

    public function getPassword(): ?string;

    public function setPassword(?string $password): void;

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAtNow(): void;

    public function getPosts(): Collection;

    public function hasPost(PostInterface $post): bool;

    public function addPost(PostInterface $post): void;

    public function removePost(PostInterface $post): void;

    public function isAdministrator(): bool;

    public function setAdministrator(bool $administrator): void;
}
