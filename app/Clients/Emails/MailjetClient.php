<?php

declare(strict_types=1);

namespace App\Clients\Emails;

use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\Services\Emails\MessageTypesInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Config\Repository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

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
     * @param Client $client
     * @param LoggerInterface $logger
     * @param Repository $config
     */
    public function __construct(Client $client, LoggerInterface $logger, Repository $config)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->url = $config->get('email-cliet-info.mailjet.url');
        $this->apiKey = $config->get('email-cliet-info.mailjet.apiKey');
        $this->secretKey = $config->get('email-cliet-info.mailjet.secretKey');
    }

    /**
     * @param MessageDTOInterface $messageDTO
     * @return bool
     * @throws GuzzleException
     */
    public function send(MessageDTOInterface $messageDTO): bool
    {
        try {
            $response = $this->client->post(
                $this->url,
                [
                    'auth' => [$this->apiKey, $this->secretKey],
                    'json' => $this->getPayload($messageDTO)
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
        return 'Mailjet';
    }

    /**
     * @param MessageDTOInterface $messageDTO
     * @return array
     */
    private function getPayload(MessageDTOInterface $messageDTO): array
    {
        return [
            'SandboxMode' => false,
            'Messages' =>
                [
                    [
                        'From' => $messageDTO->getFrom(),
                        'Subject' => $messageDTO->getSubject(),
                        'To' => $messageDTO->getRecipients(),
                        'HTMLPart' => (function(MessageDTOInterface $messageDTO) {
                            if ($messageDTO->getMessageType() !== MessageTypesInterface::MESSAGE_TYPE_TEXT) {
                                return $messageDTO->getMessage();
                            }
                        })($messageDTO),
                        'TextPart' => (function(MessageDTOInterface $messageDTO) {
                            if ($messageDTO->getMessageType() === MessageTypesInterface::MESSAGE_TYPE_TEXT) {
                                return $messageDTO->getMessage();
                            }
                        })($messageDTO),
                    ],
                ],
        ];
    }
}
