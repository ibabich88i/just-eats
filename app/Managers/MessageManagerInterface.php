<?php

declare(strict_types=1);

namespace App\Managers;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Http\Resources\MessageStoreResource;

interface MessageManagerInterface
{
    /**
     * @param MessageStoreDTOInterface $dataObject
     * @return MessageStoreResource
     */
    public function store(MessageStoreDTOInterface $dataObject): MessageStoreResource;
}
