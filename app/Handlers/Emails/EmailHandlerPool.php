<?php

declare(strict_types=1);

namespace App\Handlers\Emails;

class EmailHandlerPool implements EmailHandlerPoolInterface
{
    /**
     * @var array|EmailHandlerInterface[]
     */
    private array $handlers = [];

    /**
     * @inheritDoc
     */
    public function add(EmailHandlerInterface $instance, string $pointer): EmailHandlerPoolInterface
    {
        if (isset($this->handlers[$pointer]) === false) {
            $this->handlers[$pointer] = $instance;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $pointer): ?EmailHandlerInterface
    {
        return $this->handlers[$pointer] ?? null;
    }
}
