<?php

declare(strict_types=1);

namespace App\Models\Factories;

use App\Models\MessageModel;

interface MessageModelFactoryInterface
{
    /**
     * @param array $data
     * @return MessageModel
     */
    public function create(array $data): MessageModel;
}
