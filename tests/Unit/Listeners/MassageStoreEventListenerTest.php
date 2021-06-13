<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Events\MessageStoreEvent;
use App\Listeners\MassageStoreEventListener;
use App\Services\Emails\EmailNotificationServiceInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class MassageStoreEventListenerTest extends TestCase
{
    public function testHandlingSuccess()
    {
        $service = $this->createMock(EmailNotificationServiceInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $event = $this->createMock(MessageStoreEvent::class);
        $messageStoreDTO = $this->createMock(MessageStoreDTOInterface::class);

        $massageStoreEventListener = new MassageStoreEventListener($service, $logger);

        $event->expects($this->once())->method('getDataObject')->willReturn($messageStoreDTO);
        $logger->expects($this->once())->method('info')->with('Consumer App\Listeners\MassageStoreEventListener started processing.');
        $service->expects($this->once())->method('process')->with($messageStoreDTO);

        $massageStoreEventListener->handle($event);
    }
}
