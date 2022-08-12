<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['user_id', 'day_id'])]
class Post implements PostInterface
{
    use ResourceTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
    private ?UserInterface $user = null;

    #[ORM\ManyToOne(targetEntity: Day::class)]
    private ?DayInterface $day = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $imagePath = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Reaction::class)]
    private Collection $reactions;

    public function __construct()
    {
        $this->reactions = new ArrayCollection();
    }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAtNow(): void
    {
        $this->createdAt = new \DateTime();
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

    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function hasReaction(ReactionInterface $reaction): bool
    {
        return $this->reactions->contains($reaction);
    }

    public function addReaction(ReactionInterface $reaction): void
    {
        if (!$this->hasReaction($reaction)) {
            $reaction->setPost($this);
            $this->reactions->add($reaction);
        }
    }

    public function removeReaction(ReactionInterface $reaction): void
    {
        if ($this->hasReaction($reaction)) {
            $reaction->setPost(null);
            $this->reactions->removeElement($reaction);
        }
    }

    public function getReactionForUser(UserInterface $user): ?ReactionInterface
    {
        /** @var ReactionInterface $reaction */
        foreach ($this->reactions as $reaction) {
            if ($reaction->getUser() === $user) {
                return $reaction;
            }
        }

        return null;
    }
}
