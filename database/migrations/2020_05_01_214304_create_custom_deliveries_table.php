<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('custom_order_id')->nullable()->unsigned();
            $table->foreign('custom_order_id')->references('id')->on('custom_orders');
            $table->string('customer_name', 191)->nullable();
            $table->string('status', 191)->nullable();
            $table->string('ETA', 191)->nullable();
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
        Schema::dropIfExists('custom_deliveries');
    }
}
