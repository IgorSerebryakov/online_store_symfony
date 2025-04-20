<?php

namespace App\Exception;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Webmozart\Assert\InvalidArgumentException;

#[AsEventListener(event: ExceptionEvent::class)]
class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        dd($exception);
        $message = [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];

        if ($exception instanceof HttpExceptionInterface) {
            $message['code'] = $exception->getStatusCode();
        }

        if ($exception instanceof InvalidArgumentException) {
            $message['code'] = Response::HTTP_BAD_REQUEST;
        }

        $response = new JsonResponse($message, $message['code']);

        $event->setResponse($response);
    }
}