<?php

declare(strict_types=1);

namespace App\Handlers\Emails;

use App\DataTransferObjects\Builders\MessageDTOBuilderInterface;
use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\DataTransferObjects\MessageStoreDTOInterface;
use App\Services\Emails\MessageTypesInterface;

class UserChangePasswordEmailHandler implements EmailHandlerInterface
{
    /**
     * @var MessageDTOBuilderInterface
     */
    private MessageDTOBuilderInterface $messageDTOBuilder;

    /**
     * @var string
     */
    private string $appUrl;

    /**
     * UserChangePasswordEmailHandler constructor.
     * @param MessageDTOBuilderInterface $messageDTOBuilder
     * @param string $appUrl
     */
    public function __construct(
        MessageDTOBuilderInterface $messageDTOBuilder,
        string $appUrl
    ) {
        $this->messageDTOBuilder = $messageDTOBuilder;
        $this->appUrl = $appUrl;
    }

    /**
     * @inheritDoc
     */
    public function handle(MessageStoreDTOInterface $messageStoreDTO): MessageDTOInterface
    {
        return $this->messageDTOBuilder
            ->setRecipients($messageStoreDTO->getRecipients())
            ->setTemplateName('user-chanche-password')
            ->setSubject('Password changing.')
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
            'link' => sprintf('%s/users/change-password?token=%s', $this->appUrl, urlencode($data['token']))
        ];
    }
}
