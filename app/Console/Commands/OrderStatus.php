<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:status {state_order_id = 2}';

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
        $order = Order::where('state_order_id', 1)->update([
            'state_order_id' => 2
        ]);

        $this->table($cabecera, $order);

        $this->info('Status change !');
    }
}
