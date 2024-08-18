<?php

declare(strict_types=1);

namespace App\EventListener;

use Monolog\Logger;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use thiagoalessio\TesseractOCR\UnsuccessfulCommandException;

final class ExceptionUnsuccessfulCommandListener
{
    public function __construct(
        private readonly Logger $logger
    ) {
    }

    #[AsEventListener(event: KernelEvents::EXCEPTION)]
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof UnsuccessfulCommandException) {
            return;
        }

        $this->logger->log(
            level: LogLevel::ERROR,
            message: $exception->getMessage()
        );

        return;
    }
}
