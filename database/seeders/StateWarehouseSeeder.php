<?php

namespace Database\Seeders;

use App\Models\StateWarehouse;
use Illuminate\Database\Seeder;

class StateWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StateWarehouse::create([
            "code" => "1",
            "name" => "Bodega Activa",
            "active" => 1
        ]);

        StateWarehouse::create([
            "code" => "2",
            "name" => "Bodega Inactiva",
            "active" => 1
        ]);
    }
}
