<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            "code"     =>  "CO",
            "name"     =>  "Colombia",
            'phonecode' => 57,
            "active"   =>  1
        ]);
    }
}
