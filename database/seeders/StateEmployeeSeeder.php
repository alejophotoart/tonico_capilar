<?php

namespace Database\Seeders;

use App\Models\StateEmployee;
use Illuminate\Database\Seeder;

class StateEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StateEmployee::create([
            "code" => "1",
            "name" => "Empleado Activo",
            "active" => 1
        ]);

        StateEmployee::create([
            "code" => "2",
            "name" => "Empleado Inactivo",
            "active" => 1
        ]);
    }
}
