<?php

namespace App\Command;




use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'role_ajust',
    description: 'Ajuste lmes roles pour les users',
)]
class RoleAjustCommand extends Command
{
    public function __construct(private UserRepository $UserRepository, private EntityManagerInterface $entityManager )
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        /*$this->requirePassword = $requirePassword;*/

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /*        $io = new SymfonyStyle($input, $output);
                $arg1 = $input->getArgument('arg1');

                if ($arg1) {
                    $io->note(sprintf('You passed an argument: %s', $arg1));
                }

                if ($input->getOption('option1')) {
                    // ...
                }

                $io->success('You have a new command! Now make it your own! Pass --help to see your options.');*/


        $user = $this->UserRepository->findOneBy(['email'=> 'a@a.fr']);
        $user->setRoles(['ROLE_ADMIN']);


        $this->entityManager->flush();




        return Command::SUCCESS;
    }
}