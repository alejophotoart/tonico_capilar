<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([ "code"   =>  1, "name"   =>	"ContraEntrega"   , "active" => 1 ]);
        PaymentType::create([ "code"   =>  2, "name"   =>	"Deposito"  , "active" => 1 ]);
    }
}
