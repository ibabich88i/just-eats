<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DataTransferObjects\MessageStoreDTOInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MessageHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public const QUEUE_NAME = 'email-messages';

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
        $this->onQueue(self::QUEUE_NAME);

        $this->dataObject = $dataObject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }
}
