<?php

namespace App\Listeners;

use App\Events\MessageStoreEvent;
use App\Services\Emails\EmailNotificationServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Psr\Log\LoggerInterface;

class MassageStoreEventListener implements ShouldQueue
{
    /**
     * @var EmailNotificationServiceInterface
     */
    private EmailNotificationServiceInterface $service;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EmailNotificationServiceInterface $service, LoggerInterface $logger)
    {
        $this->service = $service;
        $this->logger = $logger;
    }

    /**
     * Handle the event.
     *
     * @param MessageStoreEvent $event
     * @return void
     */
    public function handle(MessageStoreEvent $event)
    {
        $this->logger->info(sprintf('Consumer %s started processing.', self::class));

        $this->service->process($event->getDataObject());
    }

    /**
     * @param string $name
     * @return string
     */
    public function __get(string $name)
    {
        if ('queue' === $name) {
            return config('queues.queue_send_email');
        }
    }
}
