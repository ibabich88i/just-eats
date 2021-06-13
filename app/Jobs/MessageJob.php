<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Services\Emails\EmailNotificationServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psr\Log\LoggerInterface;

class MessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var MessageStoreDTOInterface
     */
    private MessageStoreDTOInterface $dataObject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MessageStoreDTOInterface $dataObject)
    {
        $this->dataObject = $dataObject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EmailNotificationServiceInterface $service, LoggerInterface $logger)
    {
        $logger->info(sprintf('Job %s start processing.', self::class));

        $service->process($this->dataObject);
    }
}
