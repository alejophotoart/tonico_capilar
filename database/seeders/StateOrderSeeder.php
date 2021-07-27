<?php

namespace Database\Seeders;

use App\Models\StateOrder;
use Illuminate\Database\Seeder;

class StateOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StateOrder::create([
            "code" => 1,
            "name" => "Orden nueva",
            "active" => 1
        ]);
        StateOrder::create([
            "code" => 2,
            "name" => "Orden en proceso",
            "active" => 1
        ]);
        StateOrder::create([
            "code" => 3,
            "name" => "Orden entregada",
            "active" => 1
        ]);
        StateOrder::create([
            "code" => 4,
            "name" => "Orden cancelada",
            "active" => 1
        ]);
        StateOrder::create([
            "code" => 5,
            "name" => "Orden pendiente",
            "active" => 1
        ]);
        StateOrder::create([
            "code" => 6,
            "name" => "Orden pendiente logistica",
            "active" => 1
        ]);
    }
}
