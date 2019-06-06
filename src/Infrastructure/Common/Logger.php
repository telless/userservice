<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace App\Infrastructure\Common;

use Monolog\Logger as Monolog;
use Psr\Log\LoggerInterface;

class Logger
{
    private $logger;
    private $throwExceptions;

    public function __construct(LoggerInterface $logger, bool $throwExceptions = false)
    {
        $this->logger = $logger;
        $this->throwExceptions = $throwExceptions;
    }

    public function debug(string $message, array $context)
    {
        $this->log($message, $context, Monolog::DEBUG);
    }

    public function notice(string $message, array $context)
    {
        $this->log($message, $context, Monolog::NOTICE);
    }

    public function warning(string $message, array $context)
    {
        $this->log($message, $context, Monolog::WARNING);
    }

    public function critical(string $message, array $context)
    {
        $this->log($message, $context, Monolog::CRITICAL);
    }

    private function log(string $message, array $context, int $level)
    {
        try {
            $this->logger->log($level, $message, $context);
        } catch (\Throwable $e) {
            if ($this->throwExceptions) {
                throw $e;
            }
            // else do nothing
        }
    }
}