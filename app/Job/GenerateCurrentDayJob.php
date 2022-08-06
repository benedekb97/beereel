<?php

declare(strict_types=1);

namespace App\Job;

use App\Entity\Day;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class GenerateCurrentDayJob
{
    private const TIME_MINIMUM = '09:00:00';
    private const TIME_MAXIMUM = '22:00:00';

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(): void
    {
        $day = new Day();

        $day->setTime($this->generateTime());

        $this->entityManager->persist($day);
        $this->entityManager->flush();
    }

    private function generateTime(): \DateTimeInterface
    {
        return new \DateTime();
    }

    private function getCurrentDay()
    {

    }
}
