<?php

declare(strict_types=1);

namespace App\Clients\Emails;

use Iterator;

class EmailClientPool implements EmailClientPoolInterface, Iterator
{
    /**
     * @var int
     */
    private int $position = 0;

    /**
     * @var array|EmailClientInterface[]
     */
    private array $clients = [];

    /**
     * EmailClientPool constructor.
     */
    public function __construct()
    {
        $this->position = 0;
    }

    /**
     * @inheritDoc
     */
    public function add(EmailClientInterface $instance): EmailClientPoolInterface
    {
        if (in_array($instance, $this->clients) === false) {
            $this->clients[] = $instance;
        }

        return $this;
    }

    /**
     * @return EmailClientPoolInterface
     */
    public function current(): EmailClientPoolInterface
    {
        return $this->clients[$this->position];
    }

    /**
     * @return void
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->clients[$this->position]);
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }
}
