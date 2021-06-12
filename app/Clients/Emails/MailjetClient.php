<?php

declare(strict_types=1);

namespace App\Clients\Emails;

use App\DataTransferObjects\MessageDTOInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Config\Repository;
use Psr\Log\LoggerInterface;

class MailjetClient implements MailjetClientInterface, EmailClientInterface
{
    /**
     * @var ClientInterface|Client
     */
    private ClientInterface $client;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */
    private string $apiKey;

    /**
     * @var string
     */
    private string $secretKey;

    /**
     * MailjetClient constructor.
     */
    public function __construct(Client $client, LoggerInterface $logger, Repository $config)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->url = $config->get('email-cliet-info.mailjet.url');
        $this->apiKey = $config->get('email-cliet-info.apiKey.');
        $this->secretKey = $config->get('email-cliet-info.secretKey.');
    }

    /**
     * @param MessageDTOInterface $messageDTO
     * @return bool
     * @throws GuzzleException
     */
    public function send(MessageDTOInterface $messageDTO): bool
    {
        $response = $this->client->post(
            $this->url,
            [
                'auth' => [$this->apiKey, $this->secretKey],
                'json' => [
                    'SandboxMode' => false,
                    'Messages' =>
                        [
                            [
                                'From' =>
                                    [
                                        'Email' => 'ibabich88i@gmail.com',
                                        'Name' => 'Your Mailjet Pilot',
                                    ],
                                'HTMLPart' => '<h3>Dear passenger, welcome to Mailjet!</h3><br />May the delivery force be with you!',
                                'Subject' => 'Your email flight plan!',
                                'TextPart' => 'Dear passenger, welcome to Mailjet! May the delivery force be with you!',
                                'To' =>
                                    [
                                        [
                                            'Email' => 'ibabich88i@gmail.com',
                                            'Name' => 'Your Mailjet Pilot1111',
                                        ],
                                        [
                                            'Email' => 'alebab@ciklum.com',
                                            'Name' => 'Your Mailjet Pilot1111',
                                        ],
                                    ],
                            ],
                        ],
                ]
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getClientName(): string
    {
        return 'Mailjet';
    }
}
