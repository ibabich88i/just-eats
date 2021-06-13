<?php

declare(strict_types=1);

namespace Tests\Unit\Clients\Emails;

use App\Clients\Emails\MailjetClient;
use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Config\Repository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class MailjetClientTest extends TestCase
{
    /**
     * @var Client|MockObject
     */
    private MockObject $guzzleClient;

    /**
     * @var MockObject|LoggerInterface
     */
    private MockObject $logger;

    /**
     * @var Repository|MockObject
     */
    private MockObject $config;

    /**
     * @var MailjetClient
     */
    private MailjetClient $mailjetClient;

    protected function setUp(): void
    {
        $this->guzzleClient = $this->createMock(Client::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->config = $this->createMock(Repository::class);

        $this->config->expects($this->exactly(3))->method('get')->willReturn('');

        $this->mailjetClient = new MailjetClient(
            $this->guzzleClient,
            $this->logger,
            $this->config
        );
    }

    public function testSendSuccess()
    {
        $messageDTO = $this->createMock(MessageDTOInterface::class);
        $response = $this->createMock(Response::class);

        $this->guzzleClient
            ->expects($this->once())
            ->method('post')
            ->willReturn($response);

        $response->expects($this->once())->method('getStatusCode')->willReturn(200);

        $result = $this->mailjetClient->send($messageDTO);

        $this->assertTrue($result);
    }

    public function testGetClientNameSuccess()
    {
        $this->assertEquals('Mailjet', $this->mailjetClient->getClientName());
    }
}
