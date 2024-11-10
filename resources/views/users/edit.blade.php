<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Nome:</label>
                        <input type="text" id="name" name="name" class="w-full mt-1 rounded-md shadow-sm border-gray-300"
                               value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email:</label>
                        <input type="email" id="email" name="email" class="w-full mt-1 rounded-md shadow-sm border-gray-300"
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Senha (deixe em branco para manter a mesma):</label>
                        <input type="password" id="password" name="password" class="w-full mt-1 rounded-md shadow-sm border-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700">Confirme a Senha:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full mt-1 rounded-md shadow-sm border-gray-300">
                    </div>
                    <div class="mb-4">
                        <label for="perfis" class="block text-gray-700">Perfis:</label>
                        <select name="perfis[]" id="perfis" class="w-full mt-1 rounded-md shadow-sm border-gray-300" multiple required>
                            @foreach($perfis as $perfil)
                                <option value="{{ $perfil->id }}" {{ $user->perfis->contains($perfil->id) ? 'selected' : '' }}>
                                    {{ $perfil->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Salvar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
