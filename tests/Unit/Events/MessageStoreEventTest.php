<?php

declare(strict_types=1);

namespace Tests\Unit\Events;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Events\MessageStoreEvent;
use PHPUnit\Framework\TestCase;

class MessageStoreEventTest extends TestCase
{
    public function testHandlingSuccess()
    {
        $dataObject = $this->createMock(MessageStoreDTOInterface::class);

        $event = new MessageStoreEvent($dataObject);

        $this->assertInstanceOf(MessageStoreDTOInterface::class, $event->getDataObject());
    }
}
