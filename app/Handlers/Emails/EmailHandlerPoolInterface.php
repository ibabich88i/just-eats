<?php

declare(strict_types=1);

namespace App\Handlers\Emails;

interface EmailHandlerPoolInterface
{
    /**
     * @param EmailHandlerInterface $instance
     * @param string $pointer
     * @return $this
     */
    public function add(EmailHandlerInterface $instance, string $pointer): self;

    /**
     * @param string $pointer
     * @return null|EmailHandlerInterface
     */
    public function get(string $pointer): ?EmailHandlerInterface;
}
