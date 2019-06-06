<?php

namespace App\Domain\User\ReadModel;

interface UserQueryService
{
    public function list(int $limit): array;
}