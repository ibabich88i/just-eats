<?php

declare(strict_types=1);

namespace App\Handlers\Emails;

use App\DataTransferObjects\Builders\MessageDTOBuilderInterface;
use App\DataTransferObjects\MessageStoreDTOInterface;
use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\Services\Emails\MessageTypesInterface;

class CustomerRegisteredEmailHandler implements EmailHandlerInterface
{
    /**
     * @var MessageDTOBuilderInterface
     */
    private MessageDTOBuilderInterface $messageDTOBuilder;

    /**
     * CustomerRegisteredEmailHandler constructor.
     * @param MessageDTOBuilderInterface $messageDTOBuilder
     */
    public function __construct(MessageDTOBuilderInterface $messageDTOBuilder)
    {
        $this->messageDTOBuilder = $messageDTOBuilder;
    }

    /**
     * @inheritDoc
     */
    public function handle(MessageStoreDTOInterface $messageStoreDTO): MessageDTOInterface
    {
        return $this->messageDTOBuilder
            ->setRecipients($messageStoreDTO->getRecipients())
            ->setTemplateName('customer-registered')
            ->setSubject('User registered.')
            ->setMessageType(MessageTypesInterface::MESSAGE_TYPE_HTML)
            ->setData($this->getData($messageStoreDTO->getData()))
            ->build();
    }

    /**
     * @param array $data
     * @return array
     */
    private function getData(array $data): array
    {
        return [
            'userName' => $data['name']
        ];
    }
}
