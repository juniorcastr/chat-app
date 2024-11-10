<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">
            <div class="flex justify-between mb-6">
                <!-- Botão de Criar Novo Usuário -->
                <a href="{{ route('users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                    Criar Novo Usuário
                </a>
            </div>

            <!-- Tabela de Usuários -->
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach ($users as $user)
                        <tr class="border-t border-gray-200">
                            <td class="py-3 px-6 text-sm text-gray-800">{{ $user->name }}</td>
                            <td class="py-3 px-6 text-sm text-gray-800">{{ $user->email }}</td>
                            <td class="py-3 px-6 text-sm space-x-2">
                                <!-- Botão de Visualizar Usuário -->
                                <a href="{{ route('users.show', $user) }}" class="text-blue-500 hover:text-blue-700">
                                    Visualizar
                                </a>
                                <!-- Botão de Editar Usuário -->
                                <a href="{{ route('users.edit', $user) }}" class="text-yellow-500 hover:text-yellow-700">
                                    Editar
                                </a>
                                <!-- Botão de Deletar Usuário -->
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        Deletar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
