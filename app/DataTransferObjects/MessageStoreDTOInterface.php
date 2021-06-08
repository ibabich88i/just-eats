<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

interface MessageStoreDTOInterface
{
    /**
     * @return array
     */
    public function getRecipients(): array;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return string
     */
    public function getModule(): string;

    /**
     * @return string
     */
    public function getAction(): string;
}
