<?php

declare(strict_types=1);

namespace App\Managers;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Http\Resources\MessageStoreResource;
use App\Jobs\MessageHandlerJob;

class MessageManager implements MessageManagerInterface
{
    /**
     * @inheritDoc
     */
    public function store(MessageStoreDTOInterface $dataObject): MessageStoreResource
    {
        MessageHandlerJob::dispatch($dataObject);

        return new MessageStoreResource(null);
    }
}
