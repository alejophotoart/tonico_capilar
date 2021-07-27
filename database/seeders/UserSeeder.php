<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "type_identification_id" => 8,
            "identification" => "1144104341",
            "name" => "Jose Alejandro Calderon",
            "phone" => "3154709447",
            "email" => "alejandronba98@gmail.com",
            "password" => '12345678',
            "role_id" => 1,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);

        User::create([
            "type_identification_id" => 3,
            "identification" => "1144096378",
            "name" => "Juan Sebastian Uzuriaga",
            "phone" => "3156555365",
            "email" => "alejomen98@gmail.com",
            "password" => '12345678',
            "role_id" => 2,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);

        User::create([
            "type_identification_id" => 5,
            "identification" => "66760548",
            "name" => "Ximena Rico",
            "phone" => "3173676542",
            "email" => "xrico@gmail.com",
            "password" => '12345678',
            "role_id" => 3,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);

        User::create([
            "type_identification_id" => 2,
            "identification" => "167894561",
            "name" => "Stephany Uzuriaga",
            "phone" => "3167890985",
            "email" => "teffy@gmail.com",
            "password" => '12345678',
            "role_id" => 4,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);

        User::create([
            "type_identification_id" => 1,
            "identification" => "32873489",
            "name" => "Maria Puentes",
            "phone" => "3154709447",
            "email" => "mariapuentes@gmail.com",
            "password" => '12345678',
            "role_id" => 1,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);

        User::create([
            "type_identification_id" => 7,
            "identification" => "6489340",
            "name" => "Angelica Sarria",
            "phone" => "3154709447",
            "email" => "angelicasarria@gmail.com",
            "password" => '12345678',
            "role_id" => 2,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);

        User::create([
            "type_identification_id" => 10,
            "identification" => "8349348",
            "name" => "Gabriel Uzuriaga",
            "phone" => "3154709447",
            "email" => "gabrieluzuriaga@gmail.com",
            "password" => '12345678',
            "role_id" => 3,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);

        User::create([
            "type_identification_id" => 6,
            "identification" => "0923893",
            "name" => "Victor Samuel Meneses",
            "phone" => "3154709447",
            "email" => "victor@gmail.com",
            "password" => '12345678',
            "role_id" => 4,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);

        User::create([
            "type_identification_id" => 9,
            "identification" => "8489332",
            "name" => "Alejandra Rodriguez",
            "phone" => "3154709447",
            "email" => "alejandra@gmail.com",
            "password" => '12345678',
            "role_id" => 3,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);
    }
}
