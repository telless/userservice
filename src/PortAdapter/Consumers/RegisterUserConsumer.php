<?php

namespace App\PortAdapter\Consumers;

use App\Application\User\UserService;
use App\Infrastructure\User\DelayedUserProcess;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RegisterUserConsumer implements ConsumerInterface
{
    private $userService;
    private $delayedUserProcess;

    public function __construct(DelayedUserProcess $delayedUserProcess, UserService $userService)
    {
        $this->userService = $userService;
        $this->delayedUserProcess = $delayedUserProcess;
    }

    public function execute(AMQPMessage $msg)
    {
        $data = json_decode($msg->getBody(), true);
        var_dump($data);
        var_dump($msg->getBody());
        $response = $this->userService->register($data['login'], $data['password']);
        if ($response->isSuccess()) {
            $this->delayedUserProcess->delayUserRegistrationSuccess($data['login'], $data['password']);
        } else {
            $this->delayedUserProcess->delayUserRegistrationError($data['login'], $data['password'], $response->errors());
        }

        return ConsumerInterface::MSG_ACK;
    }
}