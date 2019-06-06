<?php

namespace App\PortAdapter\Console;

use App\Application\User\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterUser extends Command
{
    protected static $defaultName = 'user:register';
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('username', 'u', InputOption::VALUE_REQUIRED, 'User login');
        $this->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'User password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getOption('username');
        $password = $input->getOption('password');

        $response = $this->userService->register($username, $password);

        $output->writeln("User registered:");
        $output->writeln(json_encode($response->normalize()));
    }

}