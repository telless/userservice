<?php

namespace App\PortAdapter\User\PersistModel;

use App\Domain\User\PersistModel\User;
use App\Domain\User\PersistModel\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserRepository
{
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repo = $entityManager->getRepository(User::class);
    }

    public function findByUuid(string $uuid): User
    {
        return $this->repo->find($uuid);
    }

    public function store(User $user): void
    {
        $this->em->persist($user);
    }
}