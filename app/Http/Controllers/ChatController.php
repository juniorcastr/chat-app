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
    public function show()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.index', compact('users'));
    }

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
