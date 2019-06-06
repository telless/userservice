<?php

namespace App\Domain\User\Authentication;

class PasswordEncoder
{
    private const DEFAULT_COST = 13;

    private $cost;

    public function __construct(?int $cost = null)
    {
        $cost = $cost ?? self::DEFAULT_COST;
        if ($cost < 4 || $cost > 31) {
            throw new \InvalidArgumentException('Cost must be in the range of 4-31');
        }

        $this->cost = $cost;
    }

    public function encode(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->cost]);
    }

    public function verify($hash, $password): bool
    {
        return password_verify($password, $hash);
    }
}