<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>

{{--    TODO: Organizar a rolagem do chat e também passar a data formatada no back--}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="chat-window">
                    <div id="messages" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                        @foreach ($messages as $message)
                            <div class="message">
                                <strong>{{ $message->user->name }}:</strong>
                                <p>{{ $message->message }}</p>
                                <small>{{ \Carbon\Carbon::parse($message->created_at)->format('H:i - d/m/y') }}</small>
                            </div>
                        @endforeach
                    </div>

                    <form id="chat-form">
                        @csrf
                        <textarea id="message-input" name="message" required placeholder="Digite sua mensagem..."></textarea>
                        <button type="submit">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Configuração do Pusher
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        });

        // Entrar no canal
        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            var messageElement = document.createElement('div');
            messageElement.className = 'message';
            messageElement.innerHTML = `
                <strong>${data.userName}:</strong>
                <p>${data.message}</p>
                <small>${data.createdAt}</small>
            `;
            var messagesDiv = document.getElementById('messages');
            messagesDiv.appendChild(messageElement);

            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        });

        // Envio da msg
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var input = document.getElementById('message-input');
            axios.post('/chat/{{ $chat->id }}/send', {
                message: input.value
            }).then(response => {
                input.value = '';
            }).catch(error => {
                console.error("Erro ao enviar mensagem:", error);
            });
        });
    </script>
</x-app-layout>
