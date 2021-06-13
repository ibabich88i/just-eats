<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Models\MessageModel;

class MessageModelCreatorBuilder implements MessageModelCreatorBuilderInterface
{
    /**
     * @var array
     */
    private array $recipients = [];

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
     * @var MessageModel
     */
    private MessageModel $model;

    /**
     * MessageModelBuilder constructor.
     * @param MessageModel $model
     */
    public function __construct(MessageModel $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function setRecipients(array $recipients): self
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setModule(string $module): self
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): void
    {
        $payload = [];
        $now = new \DateTime();

        foreach ($this->recipients as $recipient) {
            $payload[] = [
                'email' => $recipient['email'],
                'message' => $this->message,
                'module' => $this->module,
                'action' => $this->action,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $this->model->newQuery()->insert($payload);
    }
}
