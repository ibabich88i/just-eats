<?php

declare(strict_types=1);

namespace App\Services\Emails;

interface MessageTypesInterface
{
    public const MESSAGE_TYPE_HTML = 'html';
    public const MESSAGE_TYPE_TEXT = 'text';
    public const MESSAGE_TYPE_MARKDOWN = 'markdown';
}
