<?php

namespace App\PortAdapter\HTTP\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    /**
     * @Route(methods={"GET"})
     *
     * @return JsonResponse
     */
    public function info()
    {
        return new JsonResponse(['resource' => 'User service API'], JsonResponse::HTTP_OK);
    }
}