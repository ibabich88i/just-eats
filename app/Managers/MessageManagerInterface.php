<?php

declare(strict_types=1);

namespace App\Managers;

use App\DataTransferObjects\MessageStoreDTOInterface;

interface MessageManagerInterface
{
    /**
     * @param MessageStoreDTOInterface $dataObject
     */
    public function store(MessageStoreDTOInterface $dataObject);
}
