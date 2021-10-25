<?php


namespace App\Application\Common;


use App\Infrastructure\Common\Logger;

class LoggableAction implements Action
{
    private $logger;

    private $action;

    public function __construct(Logger $logger, Action $action)
    {
        $this->logger = $logger;
        $this->action = $action;
    }

    public function doSomething()
    {
        $this->logger->warning('oolo', []);
        $this->action->doSomething();
    }
}