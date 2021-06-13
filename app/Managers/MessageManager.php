<?php

declare(strict_types=1);

namespace App\Managers;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Events\MessageStoreEvent;
use Illuminate\Contracts\Events\Dispatcher;

class MessageManager implements MessageManagerInterface
{
    /**
     * @var Dispatcher
     */
    private Dispatcher $dispatcher;

    /**
     * MessageManager constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @inheritDoc
     */
    public function store(MessageStoreDTOInterface $dataObject)
    {
        $this->dispatcher->dispatch(new MessageStoreEvent($dataObject));
    }
}
