<?php

declare(strict_types=1);

namespace Tests\Unit\Clients\Emails;

use App\Clients\Emails\EmailClientInterface;
use App\Clients\Emails\EmailClientPool;
use PHPUnit\Framework\TestCase;

class EmailClientPoolTest extends TestCase
{
    public function testHandlingSuccess()
    {
        $emailClientPool = new EmailClientPool();
        $client = $this->createMock(EmailClientInterface::class);

        $this->assertInstanceOf(EmailClientPool::class, $emailClientPool->add($client));
        $this->assertInstanceOf(EmailClientInterface::class, $emailClientPool->current());
    }
}
