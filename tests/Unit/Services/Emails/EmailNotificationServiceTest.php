<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Emails;

use App\Clients\Emails\EmailClientInterface;
use App\Clients\Emails\EmailClientPool;
use App\Clients\Emails\EmailClientPoolInterface;
use App\DataTransferObjects\MessageStoreDTOInterface;
use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\Handlers\Emails\EmailHandlerInterface;
use App\Handlers\Emails\EmailHandlerPoolInterface;
use App\Models\Builders\MessageModelCreatorBuilderInterface;
use App\Services\Emails\EmailNotificationService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class EmailNotificationServiceTest extends TestCase
{
    /**
     * @var EmailHandlerPoolInterface|MockObject
     */
    private MockObject $emailHandlerPool;

    /**
     * @var EmailClientPoolInterface
     */
    private EmailClientPoolInterface $emailClientPool;

    /**
     * @var MessageModelCreatorBuilderInterface|MockObject
     */
    private MockObject $messageModelCreatorBuilder;

    /**
     * @var MockObject|LoggerInterface
     */
    private MockObject $logger;

    /**
     * @var EmailNotificationService
     */
    private EmailNotificationService $emailNotificationService;

    /**
     * @var EmailClientInterface|MockObject
     */
    private MockObject $emailClient;

    protected function setUp(): void
    {
        $this->emailHandlerPool = $this->createMock(EmailHandlerPoolInterface::class);
        $this->emailClientPool = new EmailClientPool();
        $this->messageModelCreatorBuilder = $this->createMock(MessageModelCreatorBuilderInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->emailClient = $this->createMock(EmailClientInterface::class);

        $this->emailClientPool->add($this->emailClient);

        $this->emailNotificationService = new EmailNotificationService(
            $this->emailHandlerPool,
            $this->emailClientPool,
            $this->messageModelCreatorBuilder,
            $this->logger
        );
    }

    public function testProcessSuccess()
    {
        $messageStoreDTO = $this->createMock(MessageStoreDTOInterface::class);
        $emailHandler = $this->createMock(EmailHandlerInterface::class);
        $messageDTO = $this->createMock(MessageDTOInterface::class);

        $messageStoreDTO->expects($this->exactly(2))->method('getModule')->willReturn('');
        $messageStoreDTO->expects($this->exactly(2))->method('getAction')->willReturn('');
        $messageStoreDTO->expects($this->exactly(1))->method('getRecipients')->willReturn([]);

        $this->emailHandlerPool->expects($this->once())
            ->method('get')
            ->with('.')
            ->willReturn($emailHandler);

        $emailHandler->expects($this->once())
            ->method('handle')
            ->with($messageStoreDTO)
            ->willReturn($messageDTO);

        $this->emailClient->expects($this->once())
            ->method('send')
            ->with($messageDTO)
            ->willReturn(true);
        $this->emailClient->expects($this->once())
            ->method('getClientName')
            ->willReturn('');

        $messageDTO->expects($this->once())->method('getMessage')->willReturn('');

        $this->messageModelCreatorBuilder->expects($this->once())
            ->method('setModule')
            ->with('')
            ->willReturn($this->messageModelCreatorBuilder);
        $this->messageModelCreatorBuilder->expects($this->once())
            ->method('setAction')
            ->with('')
            ->willReturn($this->messageModelCreatorBuilder);
        $this->messageModelCreatorBuilder->expects($this->once())
            ->method('setMessage')
            ->with('')
            ->willReturn($this->messageModelCreatorBuilder);
        $this->messageModelCreatorBuilder->expects($this->once())
            ->method('setRecipients')
            ->with([])
            ->willReturn($this->messageModelCreatorBuilder);
        $this->messageModelCreatorBuilder->expects($this->once())
            ->method('build');

        $this->logger->expects($this->once())->method('info')->with('Email was sent by "" client.');

        $this->emailNotificationService->process($messageStoreDTO);
    }
}
