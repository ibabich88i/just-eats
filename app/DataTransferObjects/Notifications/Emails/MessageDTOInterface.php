<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Notifications\Emails;

interface MessageDTOInterface
{
    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return array
     */
    public function getRecipients(): array;

    /**
     * @return string
     */
    public function getSubject(): string;

    /**
     * @return string
     */
    public function getFrom(): string;

    /**
     * @return string
     */
    public function getMessageType(): string;

    /**
     * @return array
     */
    public function getData(): array;
}
