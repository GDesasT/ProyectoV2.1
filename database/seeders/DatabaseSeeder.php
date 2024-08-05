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
            'user' => 'dev',
            'password' => Hash::make('niñobrasileñojugandofutbolenelvientredesumamajajaniñotodomenso'),
            'role_id' => 1,
        ]);

        user::create([
            'user' => 'admin',
            'password' => Hash::make('@comedor_fuent3'),
            'role_id' => 3,
        ]);

        user::create([
            'user' => 'ventas',
            'password' => Hash::make('ventasdeplatillos'),
            'role_id' => 3,
        ]);

        //receta luego explico xd
        DB::table('recipes')->insert([
            [
                'name' => 'Ensalada Fresca',
                'shortdesc' => 'Una ensalada fresca y saludable con ingredientes naturales.',
                'ingredient' => 'Lechuga<br>Tomate<br>Pepino<br>Zanahoria<br>Aceite de oliva<br>Sal<br>Limón',
                'description' => '1. Lava y corta la lechuga, el tomate, el pepino y la zanahoria.<br>2. Coloca todos los ingredientes en un bol grande.<br>3. Añade sal y aceite de oliva al gusto.<br>4. Exprime el limón sobre la ensalada y mezcla bien.',
                'image' => 'https://i.pinimg.com/originals/8f/e4/88/8fe488121610e8df5b01288cbb18194c.jpg', // Reemplaza con una URL real
                'timeset' => '15 minutos',
                'difficult' => 'Fácil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sopa de Pollo',
                'shortdesc' => 'Sopa reconfortante hecha con pollo y vegetales frescos.',
                'ingredient' => 'Pollo<br>Zanahoria<br>Apio<br>Cebolla<br>Ajo<br>Papas<br>Sal<br>Pimienta<br>Agua',
                'description' => '1. Cocina el pollo en agua hasta que esté tierno.<br>2. Añade las zanahorias, apio, cebolla y ajo picados.<br>3. Cocina hasta que las verduras estén tiernas.<br>4. Añade las papas y cocina hasta que estén suaves.<br>5. Sazona con sal y pimienta al gusto.',
                'image' => 'https://sazonboricua.com/wp-content/uploads/2009/06/sopa-de-pollo-con-fideos-2048x1365.jpg', // Reemplaza con una URL real
                'timeset' => '45 minutos',
                'difficult' => 'Media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arroz con Pollo',
                'shortdesc' => 'Un plato clásico de arroz con pollo y vegetales.',
                'ingredient' => 'Arroz<br>Pollo<br>Pimiento<br>Cebolla<br>Ajo<br>Guisantes<br>Tomate<br>Caldo de pollo<br>Sal<br>Pimienta<br>Aceite de oliva',
                'description' => '1. Cocina el pollo en una sartén con aceite de oliva.<br>2. Añade la cebolla, pimiento y ajo picados y sofríe.<br>3. Añade el arroz y cocina por unos minutos.<br>4. Añade el caldo de pollo y el tomate y cocina a fuego lento.<br>5. Añade los guisantes y cocina hasta que el arroz esté tierno.<br>6. Sazona con sal y pimienta al gusto.',
                'image' => 'https://www.latin-ongaku.net/wp-content/uploads/2022/10/peru-e.jpg', // Reemplaza con una URL real
                'timeset' => '30 minutos',
                'difficult' => 'Media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pasta Boloñesa',
                'shortdesc' => 'Pasta con una deliciosa salsa de carne boloñesa.',
                'ingredient' => 'Pasta<br>Carne molida<br>Tomate<br>Cebolla<br>Ajo<br>Zanahoria<br>Apio<br>Sal<br>Pimienta<br>Aceite de oliva',
                'description' => '1. Cocina la pasta según las instrucciones del paquete.<br>2. Sofríe la cebolla, el ajo, la zanahoria y el apio en aceite de oliva.<br>3. Añade la carne molida y cocina hasta que esté dorada.<br>4. Añade el tomate y cocina a fuego lento hasta que la salsa espese.<br>5. Sazona con sal y pimienta al gusto.<br>6. Mezcla la pasta con la salsa y sirve caliente.',
                'image' => 'https://static.fanpage.it/wp-content/uploads/sites/22/2021/06/spaghetti-bolognese.jpg', // Reemplaza con una URL real
                'timeset' => '40 minutos',
                'difficult' => 'Media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tacos de Carne',
                'shortdesc' => 'Tacos tradicionales de carne con cebolla y cilantro.',
                'ingredient' => 'Carne de res<br>Tortillas<br>Cebolla<br>Cilantro<br>Lima<br>Sal<br>Pimienta<br>Aceite de oliva',
                'description' => '1. Cocina la carne de res en una sartén con aceite de oliva.<br>2. Sazona con sal y pimienta al gusto.<br>3. Calienta las tortillas en una sartén.<br>4. Sirve la carne en las tortillas y añade cebolla y cilantro picados.<br>5. Exprime lima sobre los tacos antes de servir.',
                'image' => 'https://eatingrichly.com/wp-content/uploads/2017/05/taqueria-carne-asada-tacos-4157vertical.jpg', // Reemplaza con una URL real
                'timeset' => '25 minutos',
                'difficult' => 'Fácil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cazuela de Verduras',
                'shortdesc' => 'Una cazuela nutritiva llena de verduras frescas.',
                'ingredient' => 'Papas<br>Zanahorias<br>Calabacín<br>Cebolla<br>Ajo<br>Tomate<br>Caldo de verduras<br>Sal<br>Pimienta<br>Aceite de oliva',
                'description' => '1. Corta todas las verduras en trozos grandes.<br>2. Sofríe la cebolla y el ajo en aceite de oliva hasta que estén tiernos.<br>3. Añade las demás verduras y el caldo de verduras.<br>4. Cocina a fuego lento hasta que todas las verduras estén tiernas.<br>5. Sazona con sal y pimienta al gusto.',
                'image' => 'https://www.margotcosasdelavida.com/wp-content/uploads/2015/12/estofado-de-verduras-con-tofu1.jpg', // Reemplaza con una URL real
                'timeset' => '50 minutos',
                'difficult' => 'Media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pollo al Horno',
                'shortdesc' => 'Pollo al horno con hierbas y limón.',
                'ingredient' => 'Pollo<br>Limón<br>Romero<br>Tomillo<br>Ajo<br>Sal<br>Pimienta<br>Aceite de oliva',
                'description' => '1. Precalienta el horno a 200 grados Celsius.<br>2. Frota el pollo con aceite de oliva, sal, pimienta, romero y tomillo.<br>3. Coloca rodajas de limón y dientes de ajo en la bandeja de hornear.<br>4. Hornea el pollo durante 45 minutos o hasta que esté cocido.<br>5. Sirve caliente con las rodajas de limón.',
                'image' => 'https://www.deliciosi.com/images/0/12/pollo-al-horno-con-limon.jpg', // Reemplaza con una URL real
                'timeset' => '60 minutos',
                'difficult' => 'Media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
