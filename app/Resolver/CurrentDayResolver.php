<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Entity\Day;
use App\Entity\DayInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;
use Dotenv\Repository\RepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CurrentDayResolver implements CurrentDayResolverInterface
{
    private ObjectRepository $dayRepository;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->dayRepository = $entityManager->getRepository(Day::class);
    }

    public function resolve(): DayInterface
    {
        $day = $this->dayRepository->createQueryBuilder('o')
            ->where('o.time < :currentTime')
            ->setParameter('currentTime', new \DateTime())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$day instanceof DayInterface) {
            throw new NotFoundHttpException('Current day could not be found!');
        }

        return $day;
    }
}
