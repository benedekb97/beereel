<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setName('beereel:create-user');
        $this->addArgument(
            'username',
            InputArgument::REQUIRED,
            'Username'
        );
        $this->addArgument(
            'password',
            InputArgument::REQUIRED,
            'Password'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $user = new User();

        $user->setUsername($username);
        $user->setPassword(bcrypt($password));
        $user->setCreatedAtNow();

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return self::SUCCESS;
    }
}
