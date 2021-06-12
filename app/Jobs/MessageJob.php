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
        $this->onQueue(env('queues.queue_send_email'));

        $this->dataObject = $dataObject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EmailNotificationServiceInterface $service)
    {
        $service->process($this->dataObject);
    }
}
