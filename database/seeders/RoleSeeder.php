<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $o = new Role([
            'name' => 'Propietario'
        ]);

        $o->save();

        $o = new Role([
            'name' => 'Administrador'
        ]);

        $o->save();

        $o = new Role([
            'name' => 'Logistica'
        ]);

        $o->save();

        $o = new Role([
            'name' => 'Ventas'
        ]);

        $o->save();
    }
}
