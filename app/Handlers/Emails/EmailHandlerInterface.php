<?php

declare(strict_types=1);

namespace App\Handlers\Emails;

use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\DataTransferObjects\MessageStoreDTOInterface;

interface EmailHandlerInterface
{
    /**
     * @param MessageStoreDTOInterface $messageStoreDTO
     * @return MessageDTOInterface
     */
    public function handle(MessageStoreDTOInterface $messageStoreDTO): MessageDTOInterface;
}
