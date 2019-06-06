<?php

namespace App\Domain\User\PersistModel;

use App\Domain\User\Authentication\PasswordEncoder;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @ORM\Embedded(class="App\Domain\User\PersistModel\Credentials", columnPrefix=false)
     */
    private $credentials;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $registeredAt;


    private function __construct(string $uuid, string $login, string $password, PasswordEncoder $encoder)
    {
        $this->uuid = $uuid;
        $this->registeredAt = new \DateTimeImmutable();
        $this->credentials = new Credentials($login, $password, $encoder);
    }

    public static function register(
        string $uuid,
        string $login,
        string $password,
        PasswordEncoder $passwordEncoder
    ): self {
        if (mb_strlen($password) < 6) {
            throw new \DomainException('Password must contain 6+ symbols');
        }

        return new self($uuid, $login, $password, $passwordEncoder);
    }

    public function changePassword(string $oldPassword, string $newPassword, PasswordEncoder $encoder)
    {
        $this->credentials->changePassword($oldPassword, $newPassword, $encoder);
    }
}