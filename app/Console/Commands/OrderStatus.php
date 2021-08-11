<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Carbon\Carbon;


class OrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambiar estado de ordenes nuevas a en proceso';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cabecera = ['state_order_id'];

        $date = new Carbon('tomorrow');
        $date1 = $date->format('Y-m-d 00:00:00');
        $date2 = $date->format('Y-m-d 23:59:59');

        $order = Order::where('delivery_date','>=',$date1)->where('delivery_date','<=',$date2)
            ->where('state_order_id', 1)->update([
            'state_order_id' => 2
        ]);

        return;
        // $this->table($cabecera, $order);

        // $this->info('Status change !');
    }
}
