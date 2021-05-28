<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('seller_id')->nullable();
            $table->text('product_details')->nullable();
            $table->integer('qty')->default(0);
            $table->decimal('price')->default(0);
            $table->decimal('tax')->default(0);
            $table->decimal('discount')->default(0);
            $table->string('delivery_status',15)->default('pending');
            $table->string('payment_status',15)->default('unpaid');
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
        Schema::dropIfExists('order_details');
    }
}
