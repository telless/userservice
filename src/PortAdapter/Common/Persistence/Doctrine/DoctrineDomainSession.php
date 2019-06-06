<?php

namespace App\PortAdapter\Common\Persistence\Doctrine;

use App\Domain\Common\DomainSession;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineDomainSession implements DomainSession
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function clear(): void
    {
        $this->entityManager->clear();
    }

    public function close(): void
    {
        $this->entityManager->clear();
        $this->entityManager->getConnection()->close();
    }

    public function lock($object, $lockMode, $lockVersion = null): void
    {
        $this->entityManager->lock($object, $lockMode, $lockVersion);
    }

    public function beginTransaction(): void
    {
        $this->entityManager->beginTransaction();
    }

    public function commit(): void
    {
        $this->entityManager->commit();
    }

    public function rollback(): void
    {
        $this->entityManager->rollback();
    }
}