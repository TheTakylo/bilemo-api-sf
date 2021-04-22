<?php

namespace App\Listener\Kernel;

use App\Normalizer\AbstractNormalizer;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\DataCollector\ExceptionDataCollector;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener
{
    /**
     * @var ExceptionDataCollector
     */
    private $exceptionDataCollector;
    /**
     * @var SerializerInterface
     */
    private $normalizers;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(SerializerInterface $normalizers, LoggerInterface $logger, ExceptionDataCollector $exceptionDataCollector = null)
    {
        $this->exceptionDataCollector = $exceptionDataCollector;
        $this->normalizers = $normalizers;
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = null;

        foreach ($this->normalizers as $normalizer) {
            if ($normalizer instanceof AbstractNormalizer && $normalizer->support($exception)) {
                $response = $normalizer->normalize($exception);
                break;
            }
        }

        if ($response === null) {
            if ($exception instanceof HttpExceptionInterface) {
                $response = new JsonResponse(['code' => $exception->getStatusCode()], $exception->getStatusCode(), $exception->getHeaders());
            } else {
                $response = new JsonResponse(['message' => 'Internal Error', 'code' => 500], 500);

                if ($this->exceptionDataCollector !== null) {
                    $this->exceptionDataCollector->collect($event->getRequest(), $response, $event->getThrowable());
                    $this->logException($exception, sprintf('Uncaught PHP Exception %s: "%s" at %s line %s', get_class($exception), $exception->getMessage(), $exception->getFile(), $exception->getLine()));
                }
            }
        }

        $event->setResponse($response);
    }

    /**
     * Logs an exception.
     */
    protected function logException(\Throwable $exception, string $message): void
    {
        if (null !== $this->logger) {
            if (!$exception instanceof HttpExceptionInterface || $exception->getStatusCode() >= 500) {
                $this->logger->critical($message, ['exception' => $exception]);
            } else {
                $this->logger->error($message, ['exception' => $exception]);
            }
        }
    }
}