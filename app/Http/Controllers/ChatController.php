<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ChatController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="Message",
     *     type="object",
     *     required={"id", "message", "created_at", "user"},
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="message", type="string", example="Hello, how are you?"),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-12T10:20:30Z"),
     *     @OA\Property(
     *         property="user",
     *         ref="#/components/schemas/User"
     *     )
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/chats",
     *     summary="Listar usuários disponíveis para chat",
     *     tags={"Chat"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários disponíveis para chat",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     */
    public function show()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.index', compact('users'));
    }

    /**
     * @OA\Get(
     *     path="/chat/{chatId}",
     *     summary="Exibe mensagens de um chat específico",
     *     tags={"Chat"},
     *     @OA\Parameter(
     *         name="chatId",
     *         in="path",
     *         description="ID do chat",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de mensagens do chat",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items()
     *         )
     *     )
     * )
     */

    public function openChat($userId)
    {
        $user = User::findOrFail($userId);
        $chat = Chat::getOrCreateChat(Auth::user(), $user);

        $cacheKey = "chat_{$chat->id}_messages";
        $messages = Cache::remember($cacheKey, 60, function () use ($chat) {
            return $chat->messages()->latest()->get();
        });

        return view('chat.chat', compact('chat', 'messages'));
    }

    /**
     * @OA\Post(
     *     path="/api/chats/{chatId}/messages",
     *     summary="Enviar uma nova mensagem no chat",
     *     tags={"Chat"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="chatId",
     *         in="path",
     *         description="ID do chat",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"message"},
     *             @OA\Property(property="message", type="string", example="Olá, como você está?")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mensagem enviada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=404, description="Chat não encontrado"),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */

    public function sendMessage(Request $request, $chatId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::findOrFail($chatId);
        $message = Message::create([
            'chat_id' => $chat->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        event(new NewMessage($message->message, Auth::user()->name, $message->created_at));

        $cacheKey = "chat_{$chat->id}_messages";
        Cache::forget($cacheKey);

        return response()->json(['message' => $message]);
    }
}
