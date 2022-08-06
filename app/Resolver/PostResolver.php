<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Entity\Post;
use App\Entity\PostInterface;
use App\Entity\UserInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;

class PostResolver implements PostResolverInterface
{
    private CurrentDayResolverInterface $currentDayResolver;

    private ObjectRepository $postRepository;

    public function __construct(
        CurrentDayResolver $currentDayResolver,
        EntityManager $entityManager
    ) {
        $this->currentDayResolver = $currentDayResolver;
        $this->postRepository = $entityManager->getRepository(Post::class);
    }

    public function resolve(UserInterface $user): ?PostInterface
    {
        $day = $this->currentDayResolver->resolve();

        return $this->postRepository->createQueryBuilder('o')
            ->where('o.user = :user')
            ->andWhere('o.day = :day')
            ->setParameter('user', $user)
            ->setParameter('day', $day)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
