<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Day implements DayInterface
{
    use ResourceTrait;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time = null;

    #[ORM\OneToMany(mappedBy: 'day', targetEntity: Post::class)]
    private Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): void
    {
        $this->time = $time;
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
            $post->setDay($this);
        }
    }

    public function removePost(PostInterface $post): void
    {
        if ($this->hasPost($post)) {
            $this->posts->removeElement($post);
            $post->setDay(null);
        }
    }
}
