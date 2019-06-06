<?php

namespace App\Infrastructure\Common;

use Ramsey\Uuid\UuidFactory;

class UuidGenerator
{
    private $uuidFactory;

    public function __construct(UuidFactory $uuidFactory)
    {
        $this->uuidFactory = $uuidFactory;
    }

    public function generateUuidV4(): string
    {
        return (string)$this->uuidFactory->uuid4();
    }
}