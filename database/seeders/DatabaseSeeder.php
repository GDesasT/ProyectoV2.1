<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\user;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear roles
        DB::table('roles')->insert([
            ['type' => 'Desarrollador'],
            ['type' => 'Administrador'],
            ['type' => 'Trabajador'],
        ]);

        // Crear el usuario administrador
        user::create([
            'user' => 'admin',
            'password' => Hash::make('admin'),
            'role_id' => 2,
        ]);
    }
}
