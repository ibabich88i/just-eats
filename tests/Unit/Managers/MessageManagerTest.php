<?php

declare(strict_types=1);

namespace Tests\Unit\Managers;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Events\MessageStoreEvent;
use App\Managers\MessageManager;
use Illuminate\Contracts\Events\Dispatcher;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MessageManagerTest extends TestCase
{
    /**
     * @var MessageManager
     */
    private MessageManager $manager;

    /**
     * @var Dispatcher|MockObject
     */
    private MockObject $dispatcher;

    protected function setUp(): void
    {
        $this->dispatcher = $this->createMock(Dispatcher::class);

        $this->manager = new MessageManager($this->dispatcher);
    }

    public function testStoreSuccess()
    {
        $dataObject = $this->createMock(MessageStoreDTOInterface::class);
        $event = new MessageStoreEvent($dataObject);

        $this->dispatcher->expects($this->once())->method('dispatch')->with($event);

        $this->manager->store($dataObject);
    }
}
