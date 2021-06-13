<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Notifications\Emails;

class MessageDTO implements MessageDTOInterface
{
    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $subject;

    /**
     * @var string
     */
    private string $messageType;

    /**
     * @var array
     */
    private array $recipients;

    /**
     * @var array
     */
    private array $from;

    /**
     * @var array
     */
    private array $data;

    /**
     * MessageDTO constructor.
     * @param string $message
     * @param string $subject
     * @param string $messageType
     * @param array $recipients
     * @param array $from
     * @param array $data
     */
    public function __construct(
        string $message,
        string $subject,
        string $messageType,
        array $recipients,
        array $from,
        array $data
    ) {
        $this->message = $message;
        $this->subject = $subject;
        $this->messageType = $messageType;
        $this->recipients = $recipients;
        $this->from = $from;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @inheritDoc
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @inheritDoc
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    /**
     * @inheritDoc
     */
    public function getMessageType(): string
    {
        return $this->messageType;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }
}
