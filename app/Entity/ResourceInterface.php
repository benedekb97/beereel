<?php

declare(strict_types=1);

namespace App\Entity;

interface ResourceInterface
{
    public function getId(): ?int;

    public function setId(?int $id): void;
}
