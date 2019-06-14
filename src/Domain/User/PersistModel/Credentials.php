<?php

namespace App\Domain\User\PersistModel;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Credentials
{
    private const DEFAULT_PASSWORD_COST = 13;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $encodedPassword;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->encodedPassword = $this->encodePassword($password);
    }

    public function authenticate(string $password): bool
    {
        return $this->verifyPassword($password);
    }

    public function changePassword(string $oldPassword, string $newPassword): bool
    {
        if ($this->verifyPassword($oldPassword)) {
            $this->encodedPassword = $this->encodePassword($newPassword);

            return true;
        }

        return false;
    }

    private function encodePassword(string $password): string
    {
        /** @var string $hash */
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => self::DEFAULT_PASSWORD_COST]);

        return $hash;
    }

    private function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->encodedPassword);
    }
}