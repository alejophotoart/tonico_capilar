<?php

namespace Database\Seeders;

use App\Models\TypeIdentification;
use Illuminate\Database\Seeder;

class TypeIdentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeIdentification::create([
            "code" => "11",
            "name" => "Registro civil ",
            "active" => 1
        ]);
        TypeIdentification::create([
            "code" => "12",
            "name" => "Tarjeta de identidad ",
            "active" => 1
        ]);
        TypeIdentification::create([
            "code" => "13",
            "name" => "Cédula de ciudadanía ",
            "active" => 1
        ]);
        TypeIdentification::create([
            "code" => "21",
            "name" => "Tarjeta de extranjería ",
            "active" => 1
        ]);
        TypeIdentification::create([
            "code" => "22",
            "name" => "Cédula de extranjería ",
            "active" => 1
        ]);
        TypeIdentification::create([
            "code" => "31",
            "name" => "NIT ",
            "active" => 1
        ]);
        TypeIdentification::create([
            "code" => "41",
            "name" => "Pasaporte ",
            "active" => 1
        ]);
        TypeIdentification::create([
            "code" => "42",
            "name" => "Documento de identificación extranjero ",
            "active" => 1
        ]);
        TypeIdentification::create([
            "code" => "50",
            "name" => "NIT de otro país",
            "active" => 1
        ]);
        TypeIdentification::create([
            "code" => "91",
            "name" => "NUIP",
            "active" => 1
        ]);
    }
}
