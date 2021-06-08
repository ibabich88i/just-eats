<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

class MessageStoreDTO implements MessageStoreDTOInterface
{
    /**
     * @var array
     */
    private array $recipients;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $module;

    /**
     * @var string
     */
    private string $action;

    /**
     * MessageStoreDTO constructor.
     * @param array $recipients
     * @param string $message
     * @param string $module
     * @param string $action
     */
    public function __construct(array $recipients, string $message, string $module, string $action)
    {
        $this->recipients = $recipients;
        $this->message = $message;
        $this->module = $module;
        $this->action = $action;
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
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @inheritDoc
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
