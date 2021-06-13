<?php

declare(strict_types=1);

namespace Tests\Unit\Handlers\Emails;

use App\DataTransferObjects\Builders\MessageDTOBuilderInterface;
use App\DataTransferObjects\MessageStoreDTOInterface;
use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\Handlers\Emails\UserChangePasswordEmailHandler;
use App\Services\Emails\MessageTypesInterface;
use PHPUnit\Framework\TestCase;

class UserChangePasswordEmailHandlerTest extends TestCase
{
    public function testHandlingSuccess()
    {
        $messageDTOBuilder = $this->createMock(MessageDTOBuilderInterface::class);
        $appUrl = '';
        $messageStoreDTO = $this->createMock(MessageStoreDTOInterface::class);
        $recipients = [];
        $messageDTO = $this->createMock(MessageDTOInterface::class);

        $userChangePasswordEmailHandler = new UserChangePasswordEmailHandler($messageDTOBuilder, $appUrl);

        $messageStoreDTO->expects($this->once())->method('getRecipients')->willReturn($recipients);
        $messageStoreDTO->expects($this->once())->method('getData')->willReturn(['token' => '']);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setRecipients')
            ->with($recipients)
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setTemplateName')
            ->with('user-chanche-password')
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setSubject')
            ->with('Password changing.')
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setMessageType')
            ->with(MessageTypesInterface::MESSAGE_TYPE_HTML)
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('setData')
            ->with(['link' => '/users/change-password?token='])
            ->willReturn($messageDTOBuilder);

        $messageDTOBuilder
            ->expects($this->once())
            ->method('build')
            ->willReturn($messageDTO);

        $result = $userChangePasswordEmailHandler->handle($messageStoreDTO);

        $this->assertInstanceOf(MessageDTOInterface::class, $result);
    }
}
