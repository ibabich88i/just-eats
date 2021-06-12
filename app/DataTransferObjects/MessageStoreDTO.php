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
    private string $module;

    /**
     * @var string
     */
    private string $action;

    /**
     * @var array
     */
    private array $data;

    /**
     * MessageStoreDTO constructor.
     * @param array $recipients
     * @param array $data
     * @param string $module
     * @param string $action
     */
    public function __construct(array $recipients, array $data, string $module, string $action)
    {
        $this->recipients = $recipients;
        $this->module = $module;
        $this->action = $action;
        $this->data = $data;
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

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }
}
