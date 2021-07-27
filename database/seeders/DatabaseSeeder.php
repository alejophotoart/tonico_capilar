<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(TypeIdentificationSeeder::class);
        $this->call(StateEmployeeSeeder::class);
        $this->call(StateOrderSeeder::class);
        $this->call(UserSeeder::class);

    }
}
