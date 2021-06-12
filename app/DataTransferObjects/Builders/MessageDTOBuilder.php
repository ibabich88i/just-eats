<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Builders;

use App\DataTransferObjects\MessageDTOInterface;
use App\Services\Emails\MessageTypesInterface;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Str;

class MessageDTOBuilder implements MessageDTOBuilderInterface
{
    /**
     * @var ViewFactory
     */
    private ViewFactory $viewFactory;

    /**
     * @var string
     */
    private string $templateName;

    /**
     * @var string
     */
    private string $messageType;

    /**
     * @var array
     */
    private array $data;

    /**
     * @var array
     */
    private array $recipients;

    /**
     * @var Str
     */
    private Str $strHelper;

    /**
     * MessageDTOBuilder constructor.
     * @param ViewFactory $viewFactory
     * @param Str $strHelper
     */
    public function __construct(
        ViewFactory $viewFactory,
        Str $strHelper
    ) {
        $this->viewFactory = $viewFactory;
        $this->strHelper = $strHelper;
    }

    /**
     * @inheritDoc
     */
    public function setTemplateName(string $templateName): MessageDTOBuilderInterface
    {
        $this->templateName = $templateName;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setMessageType(string $messageType = 'html'): MessageDTOBuilderInterface
    {
        $this->messageType = $messageType;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setData(array $data): MessageDTOBuilderInterface
    {
        return $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function setRecipients(array $recipients): MessageDTOBuilderInterface
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): MessageDTOInterface
    {

    }

    /**
     * @return string|null
     */
    private function getMessage(): ?string
    {
        if ($this->messageType === MessageTypesInterface::MESSAGE_TYPE_HTML) {
            return $this->viewFactory->make($this->templateName, $this->data)->render();
        }

        if ($this->messageType === MessageTypesInterface::MESSAGE_TYPE_MARKDOWN) {
            $path = resource_path(sprintf('views/markdowns/%s.md', $this->templateName));

            if (file_exists($path)) {
                return (string) $this->strHelper->of(file_get_contents($path, true))->markdown();
            }
        }

        if ($this->messageType === MessageTypesInterface::MESSAGE_TYPE_TEXT) {
            $path = resource_path(sprintf('views/texts/%s.txt', $this->templateName));

            if (file_exists($path)) {
                return file_get_contents($path, true);
            }
        }

        return null;
    }
}
