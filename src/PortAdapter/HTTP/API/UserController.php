<?php

namespace App\PortAdapter\HTTP\API;

use App\Application\User\UserService;
use App\Infrastructure\User\DelayedUserProcess;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("user")
 */
class UserController
{
    private const DEFAULT_LIMIT = 10;

    private $userService;
    private $delayedUserService;

    public function __construct(UserService $userService, DelayedUserProcess $delayedUserProcess)
    {
        $this->userService = $userService;
        $this->delayedUserService = $delayedUserProcess;
    }

    /**
     * @Route("/register/", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {

        $this->delayedUserService->delayUserRegistration($request->get('login'), $request->get('password'));

        return new JsonResponse(null, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listUsers(Request $request)
    {
        $limit = $request->get('limit', self::DEFAULT_LIMIT);
        $userList = $this->userService->list($limit)->data();

        return new JsonResponse(['userList' => $userList], JsonResponse::HTTP_OK);
    }
}