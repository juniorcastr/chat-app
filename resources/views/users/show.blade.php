<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('users.index') }}" class="text-blue-500 hover:text-blue-700">
                    ← Voltar à lista de usuários
                </a>
            </div>

            <!-- Detalhes do Usuário -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Nome:</h3>
                        <p class="text-gray-600">{{ $user->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Email:</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Perfis:</h3>
                        <ul class="text-gray-600">
                            @foreach ($user->perfis as $perfil)
                                <li>{{ $perfil->nome }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
