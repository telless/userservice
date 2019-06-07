<?php

namespace App\Application\User;

use App\Application\Common\ApplicationResponse;
use App\Domain\Common\DomainSession;
use App\Domain\User\Authentication\PasswordEncoder;
use App\Domain\User\PersistModel\User;
use App\Domain\User\PersistModel\UserRepository;
use App\Domain\User\ReadModel\UserQueryService;
use App\Infrastructure\Common\UuidGenerator;

class UserService
{
    private $userRepository;
    private $userQueryService;
    private $uuidGenerator;
    private $domainSession;
    private $passwordEncoder;

    public function __construct(
        UserRepository $userRepository,
        UserQueryService $userQueryService,
        UuidGenerator $uuidGenerator,
        DomainSession $domainSession,
        PasswordEncoder $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->userQueryService = $userQueryService;
        $this->uuidGenerator = $uuidGenerator;
        $this->domainSession = $domainSession;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function register(string $login, string $password): ApplicationResponse
    {
        $uuid = $this->uuidGenerator->generateUuidV4();
        try {
            $user = User::register(
                $uuid,
                $login,
                $password,
                $this->passwordEncoder
            );

            $this->userRepository->store($user);
            $this->domainSession->flush();
        } catch (\DomainException $exception) {
            return ApplicationResponse::generateErrorResponse([$exception->getMessage()]);
        } finally {
            $this->domainSession->close();
        }

        return ApplicationResponse::generateSuccessResponse($uuid);
    }


    public function list(int $limit): ApplicationResponse
    {
        $users = $this->userQueryService->list($limit);
        $response = ApplicationResponse::generateSuccessResponse($users);

        return $response;
    }
}