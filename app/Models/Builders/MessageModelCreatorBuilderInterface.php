<?php

declare(strict_types=1);

namespace App\Models\Builders;

interface MessageModelCreatorBuilderInterface
{
    /**
     * @param array $recipients
     * @return self
     */
    public function setRecipients(array $recipients): self;

    /**
     * @param string $message
     * @return self
     */
    public function setMessage(string $message): self;

    /**
     * @param string $module
     * @return self
     */
    public function setModule(string $module): self;

    /**
     * @param string $action
     * @return self
     */
    public function setAction(string $action): self;

    /**
     * @return void
     */
    public function build(): void;
}
