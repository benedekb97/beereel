<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class User implements UserInterface
{
    use ResourceTrait;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private ?string $username = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Post::class)]
    private Collection $posts;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $administrator = false;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $blocked = false;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAtNow(): void
    {
        $this->createdAt = new \DateTime();
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): int
    {
        return $this->id;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
        return null;
    }

    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function hasPost(PostInterface $post): bool
    {
        return $this->posts->contains($post);
    }

    public function addPost(PostInterface $post): void
    {
        if (!$this->hasPost($post)) {
            $this->posts->add($post);
            $post->setUser($this);
        }
    }

    public function removePost(PostInterface $post): void
    {
        if ($this->hasPost($post)) {
            $this->posts->removeElement($post);
            $post->setUser(null);
        }
    }

    public function isAdministrator(): bool
    {
        return $this->administrator;
    }

    public function setAdministrator(bool $administrator): void
    {
        $this->administrator = $administrator;
    }

    public function isBlocked(): bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): void
    {
        $this->blocked = $blocked;
    }
}
