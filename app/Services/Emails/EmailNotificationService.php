<?php

declare(strict_types=1);

namespace App\Services\Emails;

use App\Clients\Emails\EmailClientInterface;
use App\Clients\Emails\EmailClientPoolInterface;
use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Handlers\Emails\EmailHandlerPoolInterface;
use App\Models\Builders\MessageModelCreatorBuilderInterface;
use Exception;
use Psr\Log\LoggerInterface;

class EmailNotificationService implements EmailNotificationServiceInterface
{
    /**
     * @var EmailHandlerPoolInterface
     */
    private EmailHandlerPoolInterface $emailHandlerPool;

    /**
     * @var EmailClientPoolInterface
     */
    private EmailClientPoolInterface $emailClientPool;

    /**
     * @var MessageModelCreatorBuilderInterface
     */
    private MessageModelCreatorBuilderInterface $messageModelCreatorBuilder;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * EmailNotificationService constructor.
     * @param EmailHandlerPoolInterface $emailHandlerPool
     * @param EmailClientPoolInterface $emailClientPool
     * @param MessageModelCreatorBuilderInterface $messageModelCreatorBuilder
     * @param LoggerInterface $logger
     */
    public function __construct(
        EmailHandlerPoolInterface $emailHandlerPool,
        EmailClientPoolInterface $emailClientPool,
        MessageModelCreatorBuilderInterface $messageModelCreatorBuilder,
        LoggerInterface $logger
    ) {
        $this->emailHandlerPool = $emailHandlerPool;
        $this->emailClientPool = $emailClientPool;
        $this->messageModelCreatorBuilder = $messageModelCreatorBuilder;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function process(MessageStoreDTOInterface $messageStoreDTO)
    {
        $pointer = sprintf('%s.%s', $messageStoreDTO->getModule(), $messageStoreDTO->getAction());
        $handler = $this->emailHandlerPool->get($pointer);
        $messageObject = $handler->handle($messageStoreDTO);

        /** @var EmailClientInterface $client */
        foreach ($this->emailClientPool as $client) {
            try {
                $result = $client->send($messageObject);

                if ($result === true) {
                    $this->messageModelCreatorBuilder
                        ->setModule($messageStoreDTO->getModule())
                        ->setAction($messageStoreDTO->getAction())
                        ->setMessage($messageObject->getMessage())
                        ->setRecipients($messageStoreDTO->getRecipients())
                        ->build();

                    $this->logger->info(
                        sprintf('Email was sent by "%s" client.', $client->getClientName())
                    );

                    break;
                }
            } catch (Exception $exception) {
                $this->logger->error(
                    sprintf('%s:%s - %s', __METHOD__, __LINE__, $exception->getMessage()),
                    $exception->getTrace()
                );
            }
        }
    }
}
