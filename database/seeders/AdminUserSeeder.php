<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Perfil;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPerfil = Perfil::firstOrCreate([
            'nome' => 'Admin'
        ]);

        $adminUser = User::firstOrCreate(
            [
                'email' => 'admin@admin.com'
            ],
            [
                'name' => 'Admin User',
                'password' => Hash::make('123123123')
            ]
        );

        if (!$adminUser->perfis->contains($adminPerfil->id)) {
            $adminUser->perfis()->attach($adminPerfil);
        }
    }
}
