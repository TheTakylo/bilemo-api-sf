<?php

namespace App\Listener\Kernel;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExceptionListener implements EventSubscriberInterface
{
    /**
     * @var $normalizers
     */
    private $normalizers;

    public function __construct(iterable $normalizers)
    {
        $this->normalizers = $normalizers;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = null;

        foreach ($this->normalizers as $normalizer) {
            if ($normalizer instanceof NormalizerInterface && $normalizer->supportsNormalization($exception)) {
                $response = $normalizer->normalize($exception);
                break;
            }
        }

        if ($response === null) {
            if ($exception instanceof HttpExceptionInterface) {
                $response = new JsonResponse(['message' => $exception->getStatusCode()], $exception->getStatusCode(), $exception->getHeaders());
            } else {
                $response = new JsonResponse(['message' => 'Internal Error'], 500);
            }
        }

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }
}