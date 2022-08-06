<?php

declare(strict_types=1);

namespace App\Entity;

interface DayInterface extends ResourceInterface
{
    public function getTime(): ?\DateTimeInterface;

    public function setTime(?\DateTimeInterface $time): void;
}
