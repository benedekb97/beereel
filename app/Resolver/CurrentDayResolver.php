<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Entity\Day;
use App\Entity\DayInterface;
use App\Generator\DayGenerator;
use App\Generator\DayGeneratorInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CurrentDayResolver implements CurrentDayResolverInterface
{
    private ObjectRepository $dayRepository;

    private DayGeneratorInterface $dayGenerator;

    public function __construct(
        EntityManager $entityManager,
        DayGenerator $dayGenerator
    ) {
        $this->dayRepository = $entityManager->getRepository(Day::class);
        $this->dayGenerator = $dayGenerator;
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
            $day = $this->dayGenerator->generate();
        }

        return $day;
    }
}
