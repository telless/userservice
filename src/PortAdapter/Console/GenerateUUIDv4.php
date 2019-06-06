<?php

namespace App\PortAdapter\Console;

use App\Infrastructure\Common\UuidGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateUUIDv4 extends Command
{
    protected static $defaultName = 'uuid:generate:v4';

    private $uuidGenerator;

    public function __construct(UuidGenerator $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->uuidGenerator->generateUuidV4());
    }
}