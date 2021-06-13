<?php

declare(strict_types=1);

namespace App\Managers;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Http\Resources\MessageStoreResource;
use App\Jobs\MessageJob;

class MessageManager implements MessageManagerInterface
{
    /**
     * @var string
     */
    private string $queueName;

    /**
     * MessageManager constructor.
     * @param string $queueName
     */
    public function __construct(string $queueName)
    {
        $this->queueName = $queueName;
    }

    /**
     * @inheritDoc
     */
    public function store(MessageStoreDTOInterface $dataObject): MessageStoreResource
    {
        MessageJob::dispatch($dataObject)->onQueue($this->queueName);

        return new MessageStoreResource(null);
    }
}
