<?php

declare(strict_types=1);

namespace App\Managers;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Http\Resources\MessageStoreResource;

class MessageManager implements MessageManagerInterface
{
    /**
     * @inheritDoc
     */
    public function store(MessageStoreDTOInterface $dataObject): MessageStoreResource
    {
        return new MessageStoreResource(null);
    }
}
