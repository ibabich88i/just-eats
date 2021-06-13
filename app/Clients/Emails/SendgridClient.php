<?php

declare(strict_types=1);

namespace App\Clients\Emails;

use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\Services\Emails\MessageTypesInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Config\Repository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class SendgridClient implements SendgridClientInterface, EmailClientInterface
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
    private string $token;

    /**
     * SendgridClient constructor.
     * @param ClientInterface $client
     * @param Repository $config
     * @param LoggerInterface $logger
     */
    public function __construct(
        ClientInterface $client,
        Repository $config,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->url = $config->get('email-cliet-info.sendgrid.url');
        $this->token = $config->get('email-cliet-info.sendgrid.apiKey');
    }

    /**
     * @inheritDoc
     */
    public function send(MessageDTOInterface $messageDTO): bool
    {
        try {
            $response = $this->client->post(
                $this->url,
                [
                    'headers' => [
                        'Authorization' => sprintf('Bearer %s', $this->token)
                    ],
                    'json' => $this->getPayload($messageDTO),
                    'debug' => true
                ]
            );

            if ($response->getStatusCode() >= Response::HTTP_BAD_REQUEST) {
                $this->logger->error(
                    sprintf('%s:%s - %s', __METHOD__, __LINE__, $response->getBody()->getContents()),
                );

                return false;
            }

            return true;
        } catch (Exception $exception) {
            $this->logger->error(
                sprintf(
                    '%s:%s - %s',
                    __METHOD__,
                    __LINE__,
                    $exception->getMessage()
                )
            );
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getClientName(): string
    {
        return 'Sendgrid';
    }

    /**
     * @param MessageDTOInterface $messageDTO
     * @return array
     */
    private function getPayload(MessageDTOInterface $messageDTO): array
    {
        return [
            "personalizations" => [
                [
                    "to" => array_map(
                        fn($recipient) => [ "email" => $recipient['email']],
                        $messageDTO->getRecipients()
                    )
                ]
            ],
            "from" => [
                "email" => $messageDTO->getFrom()
            ],
            "subject" => $messageDTO->getSubject(),
            "content" => [
                [
                    "type" => (function(MessageDTOInterface $messageDTO) {
                        $contentTypes = [
                            MessageTypesInterface::MESSAGE_TYPE_TEXT => "text/plain",
                            MessageTypesInterface::MESSAGE_TYPE_HTML => "text/html",
                            MessageTypesInterface::MESSAGE_TYPE_MARKDOWN => "text/html"
                        ];

                        return $contentTypes[$messageDTO->getMessageType()];
                    })($messageDTO),
                    "value" => $messageDTO->getMessage()
                ]
            ]
        ];
    }
}
