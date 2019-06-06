<?php

namespace App\Infrastructure\User;


interface DelayedUserProcess
{
    public function delayUserRegistration(string $login, string $password): void;

    public function delayUserRegistrationError(string $login, string $password, array $errors): void;

    public function delayUserRegistrationSuccess(string $login, string $password): void;
}