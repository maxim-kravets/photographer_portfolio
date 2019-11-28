<?php

namespace App\Command;


use App\Dto\User;
use App\Service\Helper\RegistrationInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdmin extends Command
{
    private $registration;

    public function __construct(RegistrationInterface $registration)
    {
        parent::__construct();
        $this->registration = $registration;
    }

    protected function configure()
    {
        $this
            ->setName('app:create-admin')
            ->setDescription('This command adds administrator')
            ->addArgument('name', InputArgument::REQUIRED, 'Admin name')
            ->addArgument('email', InputArgument::REQUIRED, 'Admin email')
            ->addArgument('password', InputArgument::REQUIRED, 'Admin password')
            ->addArgument('password_retyped', InputArgument::REQUIRED, 'Admin retyped password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = \trim((string) $input->getArgument('name'));
        $email = \trim((string) $input->getArgument('email'));
        $password = \trim((string) $input->getArgument('password'));
        $password_retyped = \trim((string) $input->getArgument('password_retyped'));

        $userDTO = new User($name, $email, $password, $password_retyped, true);
        $this->registration->registry($userDTO);

        $output->writeln('Admin created!');
    }

}