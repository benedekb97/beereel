<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Entity\Day;
use App\Generator\DayGenerator;
use App\Generator\DayGeneratorInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDaysForMonth extends Command
{
    private DayGeneratorInterface $dayGenerator;

    private EntityManagerInterface $entityManager;

    public function __construct(
        DayGenerator $dayGenerator,
        EntityManager $entityManager
    ) {
        parent::__construct();

        $this->dayGenerator = $dayGenerator;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setName('beereel:generate-days');
        $this->addArgument(
            'days',
            InputArgument::REQUIRED,
            'No. of days to generate'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $counter = 0;

        $number = $input->getArgument('days') ?? 50;

        for ($i = 0; $i < $number; $i++) {
            $date = (new \DateTime())->add(new \DateInterval('P' . $i . 'D'));

            if (!$this->checkDay($date)) {
                continue;
            }

            $day = $this->dayGenerator->generate($date);

            $this->entityManager->persist($day);

            $counter++;
        }

        $output->writeln('Generated ' . $counter . ' new days!');

        $this->entityManager->flush();

        return self::SUCCESS;
    }

    private function checkDay(?\DateTimeInterface $date): bool
    {
        $dayRepository = $this->entityManager->getRepository(Day::class);

        $day = $dayRepository->createQueryBuilder('o')
            ->add('where', 'o.time between :start and :end')
            ->setParameter('start', $date)
            ->setParameter('end', $date->add(new \DateInterval('P1D')))
            ->getQuery()
            ->getOneOrNullResult();

        return $day === null;
    }
}
