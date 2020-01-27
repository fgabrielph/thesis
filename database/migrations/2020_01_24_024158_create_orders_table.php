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
            $table->string('order_number')->unique();
            $table->integer('status')->unsigned()->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('grand_total', 10, 2);
            $table->bigInteger('item_count')->unsigned();

            $table->boolean('payment_status')->default(1);
            $table->string('payment_method')->nullable();

            $table->string('first_name');
            $table->string('last_name');
            $table->text('address');
            $table->string('city');
            $table->string('zip_code');
            $table->string('phone_number');
            $table->text('notes')->nullable();


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
