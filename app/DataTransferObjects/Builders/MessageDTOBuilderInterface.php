<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Builders;

use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\Services\Emails\MessageTypesInterface;

interface MessageDTOBuilderInterface
{
    /**
     * @param string $templateName
     * @return $this
     */
    public function setTemplateName(string $templateName): self;

    /**
     * @param string $messageType
     * @return $this
     */
    public function setMessageType(string $messageType = MessageTypesInterface::MESSAGE_TYPE_HTML): self;

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): self;

    /**
     * @param array $recipients
     * @return $this
     */
    public function setRecipients(array $recipients): self;

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject(string $subject): self;

    /**
     * @return MessageDTOInterface
     */
    public function build(): MessageDTOInterface;
}
