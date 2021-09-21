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
            "phone" => "1111111111",
            "email" => "alejandronba98@gmail.com",
            "password" => 'secrect',
            "role_id" => 1,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);

        User::create([
            "type_identification_id" => 8,
            "identification" => "1143867690",
            "name" => "Joan Sebastian Hinestroza",
            "phone" => "3218815792",
            "email" => "johansebastian.h@outlook.es",
            "password" => 'secrect',
            "role_id" => 1,
            "city_id" => 1,
            "employee_state_id" => 1,
            "active" => 1
        ]);
    }
}
