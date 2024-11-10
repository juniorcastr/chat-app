<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="chat-container">
                    <div class="messages">
                        @foreach ($messages as $message)
                            <div class="message">
                                <strong>{{ $message->user->name }}:</strong>
                                <p>{{ $message->message }}</p>
                                <small>{{ $message->created_at }}</small>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ url('/chat/' . $chat->id . '/message') }}" method="POST">
                        @csrf
                        <textarea name="message" required placeholder="Digite sua mensagem..."></textarea>
                        <button type="submit">Enviar</button>
                    </form>
                </div>


            </div>
        </div>
    </div>


</x-app-layout>
