<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show()
    {
        // Lista todos os usuários do sistema, exceto o usuário logado
        $users = User::where('id', '!=', Auth::id())->get();

        return view('chat.index', compact('users'));
    }

    public function openChat($userId)
    {
        $user = User::findOrFail($userId);
        $chat = Chat::getOrCreateChat(Auth::user(), $user);

        $messages = $chat->messages()->latest()->get();

        return view('chat.chat', compact('chat', 'messages'));
    }

    public function sendMessage(Request $request, $chatId)
    {
        $request->validate([                    //AQUI EU PODERIA TER CRIADO UM REQUEST SEPARADO E PASSADO COMO PARAMETRO, MAS VAI FICAR ASSIM
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::findOrFail($chatId);
        $message = Message::create([
            'chat_id' => $chat->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        broadcast(new NewMessage($message)); // Broadcasting the new message

        return back();
    }
}
