<?php

declare(strict_types=1);

namespace App\Events;

use App\DataTransferObjects\MessageStoreDTOInterface;

class MessageStoreEvent
{
    /**
     * @var MessageStoreDTOInterface
     */
    private MessageStoreDTOInterface $dataObject;

    /**
     * MessageStoreEvent constructor.
     * @param MessageStoreDTOInterface $dataObject
     */
    public function __construct(MessageStoreDTOInterface $dataObject)
    {
        $this->dataObject = $dataObject;
    }

    /**
     * @return MessageStoreDTOInterface
     */
    public function getDataObject(): MessageStoreDTOInterface
    {
        return $this->dataObject;
    }
}
