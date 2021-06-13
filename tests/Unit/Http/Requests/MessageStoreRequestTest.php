<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\MessageStoreRequest;
use PHPUnit\Framework\TestCase;

class MessageStoreRequestTest extends TestCase
{
    /**
     * @var MessageStoreRequest
     */
    private MessageStoreRequest $messageStoreRequest;

    protected function setUp(): void
    {
        $this->messageStoreRequest = new MessageStoreRequest();
    }

    public function testAuthorizeSuccess()
    {
        $this->assertTrue($this->messageStoreRequest->authorize());
    }

    public function testRulesSuccess()
    {
        $this->assertEquals(
            [
                'recipients' => ['required', 'array'],
                'recipients.*.email' => ['required', 'email'],
                'data' => ['required', 'array'],
                'module' => ['required', 'string'],
                'action' => ['required', 'string'],
            ],
            $this->messageStoreRequest->rules()
        );
    }
}
