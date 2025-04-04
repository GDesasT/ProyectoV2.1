<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

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
            ['type' => 'Dev'],
            ['type' => 'Admin'],
            ['type' => 'Employee'],
        ]);

        // Crear usuarios
        User::create([
            'user' => 'dev',
            'password' => Hash::make('niñobrasileñojugandofutbolenelvientredesumamajajaniñotodomenso'),
            'role_id' => 1,
        ]);

        User::create([
            'user' => 'admin',
            'password' => Hash::make('@comedor_fuent3'),
            'role_id' => 2,
        ]);



    }
}
