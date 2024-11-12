<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * @OA\Schema(
     *     schema="Perfil",
     *     type="object",
     *     required={"id", "name"},
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Admin"),
     * )
     */


    /**
     * @OA\Schema(
     *     schema="User",
     *     type="object",
     *     required={"id", "name", "email"},
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="John Doe"),
     *     @OA\Property(property="email", type="string", example="john.doe@example.com")
     * )
     */

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if (Gate::denies('viewAny', User::class)) {
                abort(403);
            }
            return $next($request);
        })->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Listar usuários",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     */

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Visualizar um usuário",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do usuário",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */

    public function show($id)
    {
        $user = User::find($id);
//        dd($user);
        return view('users.show', compact('user'));
    }

    /**
     * @OA\Get(
     *     path="/api/users/create",
     *     summary="Exibir formulário para criar um novo usuário",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Formulário para criar um novo usuário",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="perfis",
     *                 type="array",
     *                 @OA\Items()
     *             )
     *         )
     *     )
     * )
     */

    public function create()
    {
        $perfis = Perfil::all();
        return view('users.create', compact('perfis'));
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Criar um novo usuário",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "perfis"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="secret123"),
     *             @OA\Property(property="perfis", type="array", @OA\Items(type="integer", example=1))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([                               //novamente esse request poderia estar num arquivo separado, mass...
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'perfis' => 'required|array',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->perfis()->sync($validated['perfis']);
        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}/edit",
     *     summary="Exibir formulário para editar um usuário",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formulário para editar um usuário",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */
    public function edit(User $user)
    {
        $perfis = Perfil::all();
        $user->load('perfis');
        return view('users.edit', compact('user', 'perfis'));
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Atualizar um usuário existente",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "perfis"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", nullable=true, example="optionalpassword"),
     *             @OA\Property(property="perfis", type="array", @OA\Items(type="integer", example=1))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=404, description="Usuário não encontrado"),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'perfis' => 'required|array',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->perfis()->sync($validated['perfis']);
        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Excluir um usuário",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário excluído com sucesso"
     *     ),
     *     @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
