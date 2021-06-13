<?php

declare(strict_types=1);

namespace Tests\Unit\DataTransferObjects;

use App\DataTransferObjects\MessageStoreDTO;
use PHPUnit\Framework\TestCase;

class MessageStoreDTOTest extends TestCase
{
    public function testHandlingSuccess()
    {
        $recipients = [];
        $data = [];
        $module = '';
        $action = '';

        $messageStoreDTO = new MessageStoreDTO($recipients, $data, $module, $action);

        $this->assertEquals($recipients, $messageStoreDTO->getRecipients());
        $this->assertEquals($data, $messageStoreDTO->getData());
        $this->assertEquals($module, $messageStoreDTO->getModule());
        $this->assertEquals($action, $messageStoreDTO->getAction());
    }
}
