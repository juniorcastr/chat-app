<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_message()
    {
        $user = User::factory()->create();
        $chat = Chat::factory()->create();

        $messageData = [
            'chat_id' => $chat->id,
            'user_id' => $user->id,
            'message' => 'Test message',
        ];

        $message = Message::create($messageData);

        $this->assertDatabaseHas('messages', $messageData);
        $this->assertEquals($messageData['message'], $message->message);
    }
}
