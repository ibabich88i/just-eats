<?php

declare(strict_types=1);

namespace App\Services\Emails;

use App\DataTransferObjects\MessageStoreDTOInterface;

interface EmailNotificationServiceInterface
{
    /**
     * @param MessageStoreDTOInterface $messageStoreDTO
     */
    public function process(MessageStoreDTOInterface $messageStoreDTO);
}
