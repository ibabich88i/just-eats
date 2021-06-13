<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreSuccess()
    {
        $payload = [
            'recipients' => [
                [
                    'email' => 'test@test.test'
                ]
            ],
            'data' => ['test' => 'test'],
            'module' => 'user',
            'action' => 'change-password',
        ];

        $url = route('messages.store');

        $response = $this->post($url, $payload);

        $response->assertSuccessful();
    }

    public function testStoreFailed()
    {
        $url = route('messages.store');

        $response = $this->post($url, []);

        $this->assertEquals(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        );
    }
}
