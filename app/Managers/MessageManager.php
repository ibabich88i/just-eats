<?php

declare(strict_types=1);

namespace App\Managers;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Http\Resources\MessageStoreResource;
use App\Jobs\MessageJob;

class MessageManager implements MessageManagerInterface
{
    /**
     * @inheritDoc
     */
    public function store(MessageStoreDTOInterface $dataObject): MessageStoreResource
    {
        MessageJob::dispatch($dataObject);

        return new MessageStoreResource(null);
    }
}
