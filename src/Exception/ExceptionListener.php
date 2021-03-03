<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $statusCode = $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : ($exception->getCode() === 0 ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
        $message = $statusCode >= Response::HTTP_INTERNAL_SERVER_ERROR
            ? Response::$statusTexts[$statusCode]
            : $exception->getMessage();
        $response = ['success' => false, 'data' => null, 'message' => $message];
        $event->allowCustomResponseCode();
        $event->setResponse(new JsonResponse($response, $statusCode));
    }
}
