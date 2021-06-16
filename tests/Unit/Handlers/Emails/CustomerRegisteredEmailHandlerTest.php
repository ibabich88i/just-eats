<?php

declare(strict_types=1);

namespace Tests\Unit\Handlers\Emails;

use App\DataTransferObjects\Builders\MessageDTOBuilderInterface;
use App\DataTransferObjects\MessageStoreDTOInterface;
use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\Handlers\Emails\CustomerRegisteredEmailHandler;
use App\Services\Emails\MessageTypesInterface;
use PHPUnit\Framework\TestCase;

class CustomerRegisteredEmailHandlerTest extends TestCase
{
    public function testHandlingSuccess()
    {
        $messageDTOBuilder = $this->createMock(MessageDTOBuilderInterface::class);
        $messageStoreDTO = $this->createMock(MessageStoreDTOInterface::class);
        $recipients = [];
        $messageDTO = $this->createMock(MessageDTOInterface::class);

        $customerRegisteredEmailHandler = new CustomerRegisteredEmailHandler($messageDTOBuilder);

        $messageStoreDTO->expects($this->once())->method('getRecipients')->willReturn($recipients);
        $messageStoreDTO->expects($this->once())->method('getData')->willReturn(['name' => '']);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setRecipients')
            ->with($recipients)
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setTemplateName')
            ->with('customer-registered')
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setSubject')
            ->with('User registered.')
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setMessageType')
            ->with(MessageTypesInterface::MESSAGE_TYPE_HTML)
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setData')
            ->with([
                'userName' => ''
            ])
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('build')
            ->willReturn($messageDTO);

        $result = $customerRegisteredEmailHandler->handle($messageStoreDTO);

        $this->assertInstanceOf(MessageDTOInterface::class, $result);
    }
}
