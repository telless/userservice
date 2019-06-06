<?php

namespace App\PortAdapter\Consumers;

use App\Infrastructure\Common\Logger;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class FailedRegisterUserConsumer implements ConsumerInterface
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function execute(AMQPMessage $msg)
    {
        $this->logger->critical('User register failed', json_decode($msg->getBody(), true));

        return ConsumerInterface::MSG_ACK;
    }
}