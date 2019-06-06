<?php

namespace App\Domain\User\PersistModel;

interface UserRepository
{
    public function findByUuid(string $uuid): User;

    public function store(User $user): void;
}