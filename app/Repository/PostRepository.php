<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use App\Entity\UserInterface;
use App\Resolver\CurrentDayResolver;
use App\Resolver\CurrentDayResolverInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class PostRepository implements PostRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    private CurrentDayResolverInterface $currentDayResolver;

    public function __construct(
        EntityManager $entityManager,
        CurrentDayResolver $currentDayResolver
    ) {
        $this->entityManager = $entityManager;
        $this->currentDayResolver = $currentDayResolver;
    }

    public function getCurrentPosts(): array
    {
        return $this->entityManager->getRepository(Post::class)->createQueryBuilder('o')
            ->where('o.day = :day')
            ->setParameter('day', $this->currentDayResolver->resolve())
            ->addOrderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getPostsForUser(UserInterface $user): array
    {
        return $this->entityManager->getRepository(Post::class)->createQueryBuilder('o')
            ->where('o.user = :user')
            ->setParameter('user', $user)
            ->addOrderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
