<?php

namespace Tests\Feature;

use App\Events\NewMessage;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ChatIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_send_message_and_it_triggers_event()
    {
        $user = User::factory()->create();
        $recipient = User::factory()->create();
        $chat = Chat::getOrCreateChat($user, $recipient);

        //disparo fake da msg
        Event::fake();

        // Autentica o usuário
        $this->actingAs($user);

        $response = $this->post("/chat/{$chat->id}/send", [
            'message' => 'Msg de teste',
        ]);

        // Verifica se a msg foi criada
        $this->assertDatabaseHas('messages', [
            'chat_id' => $chat->id,
            'user_id' => $user->id,
            'message' => 'Msg de teste',
        ]);

        // Verifica se o evento foi disparado
        Event::assertDispatched(NewMessage::class);

        $response->assertStatus(200);
    }
}
