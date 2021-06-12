<?php

declare(strict_types=1);

namespace App\Models\Factories;

use App\Models\MessageModel;

class MessageModelFactory implements MessageModelFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $data): MessageModel
    {
        return new MessageModel($data);
    }
}
