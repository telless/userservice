<?php

namespace App\Domain\Common;

interface DomainSession
{
    public function flush(): void;

    public function clear(): void;

    public function close(): void;

    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}