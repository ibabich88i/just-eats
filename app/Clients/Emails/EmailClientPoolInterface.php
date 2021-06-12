<?php

declare(strict_types=1);

namespace App\Clients\Emails;

interface EmailClientPoolInterface
{
    /**
     * @param EmailClientInterface $instance
     * @return $this
     */
    public function add(EmailClientInterface $instance): self;
}
