<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->datetime('delivery_date');
            $table->string('delivery_price')->nullable();
            $table->string('total')->nullable();
            $table->binary('img')->nullable();
            $table->string('link', 255)->nullable();
            $table->string('notes',250)->nullable();
            $table->string('reason',250)->nullable();

            $table->bigInteger('state_order_id')->unsigned()->default(1);;
            $table->foreign('state_order_id')->references('id')->on('state_orders');

            $table->integer('payment_type_id')->unsigned()->nullable();
            $table->foreign('payment_type_id')->references('id')->on('payment_types');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('address_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities');

            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
