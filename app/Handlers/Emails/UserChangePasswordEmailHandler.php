<?php

declare(strict_types=1);

namespace App\Handlers\Emails;

use App\DataTransferObjects\MessageDTOInterface;
use App\DataTransferObjects\MessageStoreDTOInterface;

class UserChangePasswordEmailHandler implements EmailHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle(MessageStoreDTOInterface $messageStoreDTO): MessageDTOInterface
    {

    }
}
