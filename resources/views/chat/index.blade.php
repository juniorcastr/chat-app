<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <h1>Usuários Disponíveis para Chat</h1>
                <div class="users-list">
                    @foreach ($users as $user)
                        <div class="user">
                            <a href="{{ url('/chat/' . $user->id) }}">{{ $user->name }}</a>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
