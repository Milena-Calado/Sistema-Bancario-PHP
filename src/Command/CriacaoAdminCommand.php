<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Cria um usuário no banco de dados',
)]
class CriacaoAdminCommand extends Command
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private UserRepository $users
    )
    {
        parent::__construct();
    }

    
    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'E-mail')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user = new User(); 
        $user->setEmail($email);
        $user->setPassword(
            $this->hasher->hashPassword($user, $password)
        );
        $this->users->save($user, true);

        $io->success(sprintf('Usuário %s criado!', $email));

        return Command::SUCCESS;
    }
}
