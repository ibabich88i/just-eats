<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Factories;

use App\DataTransferObjects\MessageStoreDTO;
use App\DataTransferObjects\MessageStoreDTOInterface;

class MessageStoreDTOFactory implements MessageStoreDTOFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $data): MessageStoreDTOInterface
    {
        return new MessageStoreDTO(
            $data['recipients'],
            $data['data'],
            $data['module'],
            $data['action'],
        );
    }
}
