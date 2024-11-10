<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="chat-window">
                    <div class="messages">
                        @foreach ($messages as $message)
                            <div class="message">
                                <strong>{{ $message->user->name }}:</strong>
                                <p>{{ $message->message }}</p>
                                <small>{{ $message->created_at }}</small>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ url('/chat/' . $chat->id . '/send') }}" method="POST">
                        @csrf
                        <textarea name="message" required placeholder="Digite sua mensagem..."></textarea>
                        <button type="submit">Enviar</button>
                    </form>
                </div>


            </div>
        </div>
    </div>


</x-app-layout>

<script>
    Echo.channel('chat.{{ $chat->id }}')
        .listen('NewMessage', (event) => {
            let message = event.message;
            // Exibe a nova mensagem na tela (você pode usar JavaScript para atualizações dinâmicas)
            console.log(message);
        });

    function openChatWindow() {
        document.querySelector('.chat-window').classList.toggle('open');
    }
</script>
