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

        User::create([
            'user' => 'ventas',
            'password' => Hash::make('ventasdeplatillos'),
            'role_id' => 3,
        ]);

        // Recetas predefinidas
        DB::table('recipes')->insert([
            [
                'name' => 'Ensalada Fresca',
                'shortdesc' => 'Una ensalada fresca y saludable con ingredientes naturales.',
                'ingredient' => json_encode([
                    ['name' => 'Lechuga', 'quantity' => 0.1, 'unit' => 'kg'],
                    ['name' => 'Tomate', 'quantity' => 0.05, 'unit' => 'kg'],
                    ['name' => 'Pepino', 'quantity' => 0.05, 'unit' => 'kg'],
                    ['name' => 'Zanahoria', 'quantity' => 0.03, 'unit' => 'kg'],
                    ['name' => 'Aceite de Oliva', 'quantity' => 0.01, 'unit' => 'L'],
                    ['name' => 'Sal', 'quantity' => 0.005, 'unit' => 'kg'],
                    ['name' => 'Limón', 'quantity' => 1, 'unit' => 'unidad']
                ]),
                'description' => '1. Lava y corta la lechuga, el tomate, el pepino y la zanahoria.<br>2. Coloca todos los ingredientes en un bol grande.<br>3. Añade sal y aceite de oliva al gusto.<br>4. Exprime el limón sobre la ensalada y mezcla bien.',
                'image' => 'https://i.pinimg.com/originals/8f/e4/88/8fe488121610e8df5b01288cbb18194c.jpg',
                'timeset' => '15 minutos',
                'difficult' => 'Fácil',
                'created_at' => '2024-08-12 09:00:01',
                'updated_at' => '2024-08-12 09:00:01',
            ]
        ]);

        // Productos para el inventario
        DB::table('inventories')->insert([
            [
                'name' => 'Maíz',
                'amount' => 5,
                'unit' => 'Kg',
                'type' => 'Cereales y Legumbres',
                'created_at' => '2024-08-12 09:00:05',
                'updated_at' => '2024-08-12 09:00:05',
            ],
            [
                'name' => 'Harina de Trigo',
                'amount' => 4,
                'unit' => 'Kg',
                'type' => 'Cereales y Legumbres',
                'created_at' => '2024-08-12 09:01:10',
                'updated_at' => '2024-08-12 09:01:10',
            ],
            [
                'name' => 'Tortillas',
                'amount' => 20,
                'unit' => 'Kg',
                'type' => 'Cereales y Legumbres',
                'created_at' => '2024-08-12 09:02:15',
                'updated_at' => '2024-08-12 09:02:15',  
            ],
            [
                'name' => 'Ajo',
                'amount' => 0.5,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:03:20',
                'updated_at' => '2024-08-12 09:03:20',
            ],
            [
                'name' => 'Chiles Secos',
                'amount' => 2,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:04:25',
                'updated_at' => '2024-08-12 09:04:25',
            ],
            [
                'name' => 'Chiles Frescos',
                'amount' => 3,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:05:30',
                'updated_at' => '2024-08-12 09:05:30',
            ],
            [
                'name' => 'Frijol Negro',
                'amount' => 1,
                'unit' => 'Kg',
                'type' => 'Cereales y Legumbres',
                'created_at' => '2024-08-12 09:06:35',
                'updated_at' => '2024-08-12 09:06:35',
            ],
            [
                'name' => 'Frijol Pinto',
                'amount' => 8,
                'unit' => 'Kg',
                'type' => 'Cereales y Legumbres',
                'created_at' => '2024-08-12 09:07:40',
                'updated_at' => '2024-08-12 09:07:40',
            ],
            [
                'name' => 'Lentejas',
                'amount' => 3,
                'unit' => 'Kg',
                'type' => 'Cereales y Legumbres',
                'created_at' => '2024-08-12 09:08:45',
                'updated_at' => '2024-08-12 09:08:45',
            ],
            [
                'name' => 'Arroz',
                'amount' => 30,
                'unit' => 'Kg',
                'type' => 'Cereales y Legumbres',
                'created_at' => '2024-08-12 09:09:50',
                'updated_at' => '2024-08-12 09:09:50',
            ],
            [
                'name' => 'Manteca de Cerdo',
                'amount' => 4,
                'unit' => 'Kg',
                'type' => 'Proteina',
                'created_at' => '2024-08-12 09:10:55',
                'updated_at' => '2024-08-12 09:10:55',
            ],
            [
                'name' => 'Carne de Res',
                'amount' => 10,
                'unit' => 'Kg',
                'type' => 'Proteina',
                'created_at' => '2024-08-12 09:11:00',
                'updated_at' => '2024-08-12 09:11:00',
            ],
            [
                'name' => 'Carne de Cerdo',
                'amount' => 7,
                'unit' => 'Kg',
                'type' => 'Proteina',
                'created_at' => '2024-08-12 09:12:05',
                'updated_at' => '2024-08-12 09:12:05',
            ],
            [
                'name' => 'Papa',
                'amount' => 7,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:13:10',
                'updated_at' => '2024-08-12 09:13:10',
            ],
            [
                'name' => 'Nopal',
                'amount' => 1,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:14:15',
                'updated_at' => '2024-08-12 09:14:15',
            ],
            [
                'name' => 'Calabacita',
                'amount' => 7,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:15:20',
                'updated_at' => '2024-08-12 09:15:20',
            ],
            [
                'name' => 'Aguacate',
                'amount' => 2,
                'unit' => 'Kg',
                'type' => 'Fruta',
                'created_at' => '2024-08-12 09:16:25',
                'updated_at' => '2024-08-12 09:16:25',
            ],
            [
                'name' => 'Plátano',
                'amount' => 2,
                'unit' => 'Kg',
                'type' => 'Fruta',
                'created_at' => '2024-08-12 09:17:30',
                'updated_at' => '2024-08-12 09:17:30',
            ],
            [
                'name' => 'Leche',
                'amount' => 2,
                'unit' => 'L',
                'type' => 'Lacteo',
                'created_at' => '2024-08-12 09:18:35',
                'updated_at' => '2024-08-12 09:18:35',
            ],
            [
                'name' => 'Queso Fresco',
                'amount' => 2,
                'unit' => 'Kg',
                'type' => 'Lacteo',
                'created_at' => '2024-08-12 09:19:40',
                'updated_at' => '2024-08-12 09:19:40',
            ],
            [
                'name' => 'Crema',
                'amount' => 2,
                'unit' => 'L',
                'type' => 'Lacteo',
                'created_at' => '2024-08-12 09:20:45',
                'updated_at' => '2024-08-12 09:20:45',
            ],
            [
                'name' => 'Huevos',
                'amount' => 120,
                'unit' => 'Pz',
                'type' => 'Proteina',
                'created_at' => '2024-08-12 09:21:50',
                'updated_at' => '2024-08-12 09:21:50',
            ],
            [
                'name' => 'Azúcar',
                'amount' => 50,
                'unit' => 'Kg',
                'type' => 'Especia',
                'created_at' => '2024-08-12 09:22:55',
                'updated_at' => '2024-08-12 09:22:55',
            ],
            [
                'name' => 'Canela',
                'amount' => 0.2,
                'unit' => 'Kg',
                'type' => 'Especia',
                'created_at' => '2024-08-12 09:23:00',
                'updated_at' => '2024-08-12 09:23:00',
            ],
            [
                'name' => 'Chicharrón',
                'amount' => 2,
                'unit' => 'Kg',
                'type' => 'Proteina',
                'created_at' => '2024-08-12 09:24:05',
                'updated_at' => '2024-08-12 09:24:05',
            ],
            [
                'name' => 'Atún en Lata',
                'amount' => 50,
                'unit' => 'Pz',
                'type' => 'Proteina',
                'created_at' => '2024-08-12 09:25:10',
                'updated_at' => '2024-08-12 09:25:10',
            ],
            [
                'name' => 'Lechuga',
                'amount' => 8,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:26:15',
                'updated_at' => '2024-08-12 09:26:15',
            ],
            [
                'name' => 'Tomate',
                'amount' => 15,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:27:20',
                'updated_at' => '2024-08-12 09:27:20',
            ],
            [
                'name' => 'Pepino',
                'amount' => 3,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:28:25',
                'updated_at' => '2024-08-12 09:28:25',
            ],
            [
                'name' => 'Zanahoria',
                'amount' => 20,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:29:30',
                'updated_at' => '2024-08-12 09:29:30',
            ],
            [
                'name' => 'Aceite de Oliva',
                'amount' => 50,
                'unit' => 'L',
                'type' => 'Proteina',
                'created_at' => '2024-08-12 09:30:35',
                'updated_at' => '2024-08-12 09:30:35',
            ],
            [
                'name' => 'Sal',
                'amount' => 30,
                'unit' => 'Kg',
                'type' => 'Especia',
                'created_at' => '2024-08-12 09:31:40',
                'updated_at' => '2024-08-12 09:31:40',
            ],
            [
                'name' => 'Limón',
                'amount' => 6,
                'unit' => 'Kg',
                'type' => 'Fruta',
                'created_at' => '2024-08-12 09:32:45',
                'updated_at' => '2024-08-12 09:32:45',
            ],
            [
                'name' => 'Apio',
                'amount' => 2,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:33:50',
                'updated_at' => '2024-08-12 09:33:50',
            ],
            [
                'name' => 'Cebolla',
                'amount' => 7,
                'unit' => 'Kg',
                'type' => 'Verdura',
                'created_at' => '2024-08-12 09:34:55',
                'updated_at' => '2024-08-12 09:34:55',
            ],
            [
                'name' => 'Pimienta',
                'amount' => 5,
                'unit' => 'Kg',
                'type' => 'Especia',
                'created_at' => '2024-08-12 09:35:00',
                'updated_at' => '2024-08-12 09:35:00',
            ],
            [
                'name' => 'Sazonador de Pollo',
                'amount' => 20,
                'unit' => 'Kg',
                'type' => 'Especia',
                'created_at' => '2024-08-12 09:36:05',
                'updated_at' => '2024-08-12 09:36:05',
            ],[
                'name' => 'Salchicha',
                'amount' => 10,
                'unit' => 'Kg',
                'type' => 'Embutido',
                'created_at' => '2024-08-16 09:50:00',
                'updated_at' => '2024-08-16 09:50:00',
            ],
            [
                'name' => 'Chorizo',
                'amount' => 7,
                'unit' => 'Kg',
                'type' => 'Embutido',
                'created_at' => '2024-08-16 10:00:00',
                'updated_at' => '2024-08-16 10:00:00',
            ],
            [
                'name' => 'Pepperoni',
                'amount' => 4,
                'unit' => 'Kg',
                'type' => 'Embutido',
                'created_at' => '2024-08-16 10:10:00',
                'updated_at' => '2024-08-16 10:10:00',
            ],[
                'name' => 'Longaniza',
                'amount' => 7,
                'unit' => 'Kg',
                'type' => 'Embutido',
                'created_at' => '2024-08-16 11:10:00',
                'updated_at' => '2024-08-16 11:10:00',
            ]
        ]);

        DB::table('enterprises')->insert([
            [
                'name' => 'Henniges Automotive',
                'email' => 'HennigesAutomotive@gmail.com',
                'phone' => '9713815637',
                'address' => 'Gomez Palacio - Cerca del centro trailero',
                'created_at' => '2024-08-12 09:00:05',
                'updated_at' => '2024-08-12 09:00:05',
            ]
            ]);

        $faker = Faker::create();

        $customers = [
            ['number' => '103665', 'name' => 'Cecilia', 'lastname' => 'Figueroa Ruiz', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103716', 'name' => 'Elsa', 'lastname' => 'Valenzuela Contreras', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103045', 'name' => 'Dolores', 'lastname' => 'Montiel Tapia', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103362', 'name' => 'Jeremías', 'lastname' => 'Vázquez Soto', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103459', 'name' => 'Mauro', 'lastname' => 'Molina Hidalgo', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103784', 'name' => 'Isabel', 'lastname' => 'Valenzuela Mendoza', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103430', 'name' => 'Cristóbal', 'lastname' => 'Peña Larios', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103739', 'name' => 'Jeremías', 'lastname' => 'Ruiz Pineda', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103932', 'name' => 'Alejandra', 'lastname' => 'Flores Palacios', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103929', 'name' => 'Rebeca', 'lastname' => 'Aguilar Esquivel', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103450', 'name' => 'Irene', 'lastname' => 'García Fonseca', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103866', 'name' => 'Rita', 'lastname' => 'Mora Montes', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103808', 'name' => 'Manuel', 'lastname' => 'Castro Alvarado', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103038', 'name' => 'Silvia', 'lastname' => 'Tapia Chávez', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103101', 'name' => 'Hilda', 'lastname' => 'Ochoa Miranda', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103202', 'name' => 'Edgar', 'lastname' => 'Cruz Hernández', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102764', 'name' => 'Ernesto', 'lastname' => 'Mora Guzmán', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102567', 'name' => 'Alicia', 'lastname' => 'Zamora Aranda', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102744', 'name' => 'Santiago', 'lastname' => 'Romero Pineda', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102902', 'name' => 'Bernardo', 'lastname' => 'Bermúdez Medina', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102980', 'name' => 'Alonso', 'lastname' => 'Villanueva González', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102734', 'name' => 'Esteban', 'lastname' => 'Téllez Corona', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103987', 'name' => 'Facundo', 'lastname' => 'Morales Barajas', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102753', 'name' => 'Teresa', 'lastname' => 'Aranda Ortiz', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103838', 'name' => 'Bernardo', 'lastname' => 'Peralta Gallegos', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103140', 'name' => 'Luciano', 'lastname' => 'Montiel Aranda', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103123', 'name' => 'Cristóbal', 'lastname' => 'Fuentes Ortiz', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103786', 'name' => 'Luis', 'lastname' => 'Valle Espinoza', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103335', 'name' => 'Roberta', 'lastname' => 'Miranda Escobar', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102694', 'name' => 'Marcos', 'lastname' => 'Silva Pérez', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103423', 'name' => 'Rubén', 'lastname' => 'Ríos Díaz', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103804', 'name' => 'Liliana', 'lastname' => 'Lara Chávez', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103429', 'name' => 'Silvia', 'lastname' => 'Pacheco Pizarro', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103746', 'name' => 'Omar', 'lastname' => 'Cervantes Martínez', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103505', 'name' => 'Mariana', 'lastname' => 'Espinoza Castañeda', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103386', 'name' => 'Teresa', 'lastname' => 'Vázquez Valenzuela', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103898', 'name' => 'María', 'lastname' => 'Salcedo Medina', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102583', 'name' => 'Vicente', 'lastname' => 'Espinoza Vargas', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102613', 'name' => 'Mario', 'lastname' => 'Mora Lara', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103103', 'name' => 'Juana', 'lastname' => 'Cervantes Escamilla', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103865', 'name' => 'Alejandra', 'lastname' => 'Vega Montiel', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103816', 'name' => 'Luis', 'lastname' => 'Lagos Morales', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103387', 'name' => 'Gonzalo', 'lastname' => 'Bravo Gutiérrez', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103393', 'name' => 'Rodrigo', 'lastname' => 'Bravo Campos', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103411', 'name' => 'Ricardo', 'lastname' => 'Montoya Carrasco', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102745', 'name' => 'Mónica', 'lastname' => 'Orellana Muñoz', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103879', 'name' => 'Camila', 'lastname' => 'Fuentes Fernández', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103686', 'name' => 'Alejandro', 'lastname' => 'Cordero Fernández', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103417', 'name' => 'Verónica', 'lastname' => 'Gómez López', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '102904', 'name' => 'Patricio', 'lastname' => 'Valencia Díaz', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103756', 'name' => 'Joaquín', 'lastname' => 'Ortiz Moraga', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
            ['number' => '103047', 'name' => 'Antonio', 'lastname' => 'González Gutiérrez', 'email' => $faker->unique()->userName.'@gmail.com', 'enterprise_id' => 1],
        ];
        

        DB::table('customers')->insert($customers);
    }
}
