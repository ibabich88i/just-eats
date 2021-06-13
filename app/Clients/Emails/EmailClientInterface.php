<?php

declare(strict_types=1);

namespace App\Clients\Emails;

use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;

interface EmailClientInterface
{
    /**
     * @param MessageDTOInterface $messageDTO
     * @return bool
     */
    public function send(MessageDTOInterface $messageDTO): bool;

    /**
     * @return string
     */
    public function getClientName(): string;
}
