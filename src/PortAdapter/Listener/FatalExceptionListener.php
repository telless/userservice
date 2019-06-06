<?php

namespace App\PortAdapter\Listener;

use App\Infrastructure\Common\Logger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FatalExceptionListener
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        switch (true) {
            case $exception instanceof NotFoundHttpException:
                $data = ['message' => 'Route not found'];
                $status = JsonResponse::HTTP_NOT_FOUND;
                break;
            default:
                $data = ['message' => 'Fatal exception'];
                $status = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
                $this->logger->critical(
                    $exception->getMessage(),
                    ['trace' => $exception->getTrace(), 'type' => get_class($exception)]
                );
                break;
        }

        $event->setResponse(new JsonResponse($data, $status));
    }
}