<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Reaction implements ReactionInterface
{
    use ResourceTrait;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'reactions')]
    private ?PostInterface $post = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?UserInterface $user = null;

    #[ORM\Column(type: Types::STRING, enumType: ReactionType::class)]
    private ?ReactionType $type = null;

    public function getPost(): ?PostInterface
    {
        return $this->post;
    }

    public function setPost(?PostInterface $post): void
    {
        $this->post = $post;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getType(): ?ReactionType
    {
        return $this->type;
    }

    public function setType(?ReactionType $type): void
    {
        $this->type = $type;
    }
}
