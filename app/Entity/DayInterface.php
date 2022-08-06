<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface DayInterface extends ResourceInterface
{
    public function getTime(): ?\DateTimeInterface;

    public function setTime(?\DateTimeInterface $time): void;

    public function getPosts(): Collection;

    public function hasPost(PostInterface $post): bool;

    public function addPost(PostInterface $post): void;

    public function removePost(PostInterface $post): void;
}
