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
            $table->string('customer_id',15)->nullable();
            $table->string('customer_type',10)->nullable();
            $table->string('payment_status',15)->default('unpaid');
            $table->string('order_status',15)->default('pending');
            $table->string('payment_method',15)->nullable();
            $table->string('transaction_ref',30)->nullable();
            $table->decimal('order_amount')->default(0);
            $table->text('shipping_address')->nullable();
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
