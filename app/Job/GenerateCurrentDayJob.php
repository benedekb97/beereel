<?php

declare(strict_types=1);

namespace App\Job;

use App\Entity\Day;
use App\Generator\DayGenerator;
use App\Generator\DayGeneratorInterface;
use App\Resolver\CurrentDayResolver;
use App\Resolver\CurrentDayResolverInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class GenerateCurrentDayJob
{
    private const TIME_MINIMUM = '09:00:00';
    private const TIME_MAXIMUM = '22:00:00';

    private EntityManagerInterface $entityManager;

    private CurrentDayResolverInterface $currentDayResolver;

    public function __construct(
        EntityManager $entityManager,
        CurrentDayResolver $currentDayResolver
    )
    {
        $this->entityManager = $entityManager;
        $this->currentDayResolver = $currentDayResolver;
    }

    public function __invoke(): void
    {
        $day = $this->currentDayResolver->resolve();

        $this->entityManager->persist($day);
        $this->entityManager->flush();
    }
}
