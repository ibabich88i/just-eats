<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Factories;

use App\DataTransferObjects\MessageStoreDTOInterface;

interface MessageStoreDTOFactoryInterface
{
    /**
     * @param array $data
     * @return MessageStoreDTOInterface
     */
    public function create(array $data): MessageStoreDTOInterface;
}
