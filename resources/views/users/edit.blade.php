<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('users.index') }}" class="text-blue-500 hover:text-blue-700">
                    ← Voltar à lista de usuários
                </a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $user ? 'Editar Usuário' : 'Criar Novo Usuário' }}</h2>

                <form action="{{ $user ? route('users.update', $user) : route('users.store') }}" method="POST">
                    @csrf
                    @if($user)
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label for="perfis" class="block text-sm font-medium text-gray-700">Perfis</label>
                        <select name="perfis[]" id="perfis" multiple class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @foreach ($perfis as $perfil)
                                <option value="{{ $perfil->id }}" {{ in_array($perfil->id, old('perfis', $user->perfis->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                    {{ $perfil->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                            {{ $user ? 'Atualizar Usuário' : 'Criar Usuário' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
