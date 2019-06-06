<?php

namespace App\Domain\User\PersistModel;

use App\Domain\User\Authentication\PasswordEncoder;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Credentials
{
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $encodedPassword;

    public function __construct(string $login, string $password, PasswordEncoder $encoder)
    {
        $this->login = $login;
        $this->encodedPassword = $encoder->encode($password);
    }

    public function changePassword(string $oldPassword, string $newPassword, PasswordEncoder $encoder): bool
    {
        if ($this->validatePassword($oldPassword, $encoder)) {
            $this->encodedPassword = $encoder->encode($newPassword);

            return true;
        }

        return false;
    }

    private function validatePassword(string $password, PasswordEncoder $encoder): bool
    {
        return $encoder->verify($this->encodedPassword, $password);
    }
}