<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Post implements PostInterface
{
    use ResourceTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
    private ?UserInterface $user = null;

    #[ORM\ManyToOne(targetEntity: Day::class)]
    private ?DayInterface $day = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $imagePath = null;

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): void
    {
        $this->user = $user ;
    }

    public function getDay(): ?DayInterface
    {
        return $this->day;
    }

    public function setDay(?DayInterface $day): void
    {
        $this->day = $day;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function getFrontImagePath(): ?string
    {
        return $this->getImagePath();
    }

    public function getBackImagePath(): ?string
    {
        return null !== $this->getImagePath()
            ? str_replace('front', 'back', $this->getImagePath())
            : null;
    }
}
