<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

#[AsEventListener]
class JsonExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $request = $event->getRequest();

        if ('json' !== $request->getPreferredFormat()) {
            return;
        }

        $exception = $event->getThrowable();

        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;


        $data = [
            'message' => $exception->getMessage(),
        ];

        $decoded = json_decode($exception->getMessage(), true);
        if (JSON_ERROR_NONE === json_last_error() && is_array($decoded)) {
            $data = $decoded;
            $statusCode = 400;
        }

        $response = new JsonResponse($data, $statusCode);
        $event->setResponse($response);
    }
}
