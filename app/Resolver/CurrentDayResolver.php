<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Entity\Day;
use App\Entity\DayInterface;
use App\Generator\DayGenerator;
use App\Generator\DayGeneratorInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CurrentDayResolver implements CurrentDayResolverInterface
{
    private ObjectRepository $dayRepository;

    private DayGeneratorInterface $dayGenerator;

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManager $entityManager,
        DayGenerator $dayGenerator
    ) {
        $this->dayRepository = $entityManager->getRepository(Day::class);
        $this->dayGenerator = $dayGenerator;
        $this->entityManager = $entityManager;
    }

    public function resolve(): DayInterface
    {
        $day = $this->dayRepository->createQueryBuilder('o')
            ->add('where', 'o.time between :today and :tomorrow')
            ->setParameter('today', $this->getToday())
            ->setParameter('tomorrow', $this->getTomorrow())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $day || $day->getTime() > new \DateTime()) {
            $day = $this->dayRepository->createQueryBuilder('o')
                ->add('where', 'o.time between :yesterday and :today')
                ->setParameter('yesterday', $this->getYesterday())
                ->setParameter('today', $this->getToday())
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        }

        if (!$day instanceof DayInterface) {
            $day = $this->dayGenerator->generate();

            $this->entityManager->persist($day);
            $this->entityManager->flush();
        }

        return $day;
    }

    private function getToday(): \DateTimeInterface
    {
        return new \DateTime('today');
    }

    private function getTomorrow(): \DateTimeInterface
    {
        return new \DateTime('tomorrow');
    }

    private function getYesterday(): \DateTimeInterface
    {
        return new \DateTime('yesterday');
    }
}
