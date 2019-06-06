<?php

namespace App\PortAdapter\User\Infrastructure;

use App\Infrastructure\User\DelayedUserProcess;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class RabbitMqDelayedUserProcess implements DelayedUserProcess
{
    private $registrationProducer;
    private $registrationErrorProducer;
    private $registrationSuccessProducer;

    public function __construct(
        ProducerInterface $registrationProducer,
        ProducerInterface $registrationErrorProducer,
        ProducerInterface $registrationSuccessProducer
    ) {
        $this->registrationProducer = $registrationProducer;
        $this->registrationErrorProducer = $registrationErrorProducer;
        $this->registrationSuccessProducer = $registrationSuccessProducer;
    }

    public function delayUserRegistration(string $login, string $password): void
    {
        $this->registrationProducer->publish(json_encode(['login' => $login, 'password' => $password]));
    }

    public function delayUserRegistrationError(string $login, string $password, array $errors): void
    {
        $this->registrationErrorProducer->publish(
            json_encode(['login' => $login, 'password' => $password, 'errors' => $errors])
        );
    }

    public function delayUserRegistrationSuccess(string $login, string $password): void
    {
        $this->registrationSuccessProducer->publish(json_encode(['login' => $login, 'password' => $password]));
    }
}