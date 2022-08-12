<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PostInterface;
use App\Entity\Reaction;
use App\Entity\ReactionInterface;
use App\Entity\UserInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;

class ReactionRepository implements ReactionRepositoryInterface
{
    private ObjectRepository $repository;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->repository = $entityManager->getRepository(Reaction::class);
    }

    public function findByUserAndPost(UserInterface $user, PostInterface $post): ?ReactionInterface
    {
        return $this->repository->createQueryBuilder('o')
            ->where('o.user = :user')
            ->andWhere('o.post = :post')
            ->setParameter('user', $user)
            ->setParameter('post', $post)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
