<?php


namespace App\Service\Api\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class HttpExceptionSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $e = $event->getThrowable();
        if ($e instanceof HttpException) {
            $response = new JsonResponse([
                'error'  => $e->getMessage(),
                'status' => $e->getStatusCode(),
            ], $e->getStatusCode());

            $response->headers->set('Content-Type', 'application/json');
            $event->setResponse($response);
        }
    }
}