<?php

namespace App\PortAdapter\User\ReadModel;

use App\Domain\User\ReadModel\UserQueryService;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserQueryService implements UserQueryService
{
    private $connection;

    public function __construct(EntityManagerInterface $em)
    {
        $this->connection = $em->getConnection();
    }

    /**
     * @param int $limit
     *
     * @return array
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function list(int $limit): array
    {
        $selectQuery = "SELECT uuid, login, registered_at FROM users ORDER BY registered_at DESC LIMIT {$limit};";
        $statement = $this->connection->prepare($selectQuery);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
}