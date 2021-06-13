<?php

declare(strict_types=1);

namespace Tests\Unit\Handlers\Emails;

use App\Handlers\Emails\EmailHandlerInterface;
use App\Handlers\Emails\EmailHandlerPool;
use PHPUnit\Framework\TestCase;

class EmailHandlerPoolTest extends TestCase
{
    public function testHandlingSuccess()
    {
        $emailHandler = $this->createMock(EmailHandlerInterface::class);
        $emailHandlerPool = new EmailHandlerPool();

        $this->assertInstanceOf(EmailHandlerPool::class, $emailHandlerPool->add($emailHandler, 'test'));
        $this->assertInstanceOf(EmailHandlerInterface::class, $emailHandlerPool->get('test'));
    }
}
