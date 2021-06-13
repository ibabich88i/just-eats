<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Builders;

use App\DataTransferObjects\Notifications\Emails\MessageDTO;
use App\DataTransferObjects\Notifications\Emails\MessageDTOInterface;
use App\Services\Emails\MessageTypesInterface;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Str;

class MessageDTOBuilder implements MessageDTOBuilderInterface
{
    /**
     * @var ViewFactory
     */
    private ViewFactory $viewFactory;

    /**
     * @var Str
     */
    private Str $strHelper;

    /**
     * @var Repository
     */
    private Repository $config;

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
     * @var string
     */
    private string $subject;

    /**
     * MessageDTOBuilder constructor.
     * @param ViewFactory $viewFactory
     * @param Str $strHelper
     * @param Repository $config
     */
    public function __construct(
        ViewFactory $viewFactory,
        Str $strHelper,
        Repository $config
    ) {
        $this->viewFactory = $viewFactory;
        $this->strHelper = $strHelper;
        $this->config = $config;
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
        $this->data = $data;

        return $this;
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
    public function setSubject(string $subject): MessageDTOBuilderInterface
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): MessageDTOInterface
    {
        return new MessageDTO(
            $this->getMessage(),
            $this->subject,
            $this->messageType,
            $this->config->get('email-cliet-info.from'),
            $this->recipients,
            $this->data
        );
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
