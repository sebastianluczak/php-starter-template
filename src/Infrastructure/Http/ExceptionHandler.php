<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionHandler
{
    public function onKernelException(ExceptionEvent $exceptionEvent): void
    {
        $exceptionEvent->setResponse(new JsonResponse(
            data: [
                'message' => $exceptionEvent->getThrowable()->getMessage(),
                'errno' => $exceptionEvent->getThrowable()->getLine(),
                'controller' => $exceptionEvent->getRequest()->attributes->get('_controller'),
                'client' => $exceptionEvent->getRequest()->headers->get('user-agent'),
            ],
            status: Response::HTTP_INTERNAL_SERVER_ERROR,
        ));
    }
}
