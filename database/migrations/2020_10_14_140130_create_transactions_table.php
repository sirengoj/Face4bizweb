<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id',20)->unique();
            $table->bigInteger('order_id')->nullable();
            $table->string('payment_for',100)->nullable();
            $table->bigInteger('payer_id')->nullable();
            $table->bigInteger('payment_receiver_id')->nullable();
            $table->string('paid_by',15)->nullable();
            $table->string('paid_to',15)->nullable();
            $table->string('payment_method',15)->nullable();
            $table->string('payment_status',10)->default('success');
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
        Schema::dropIfExists('transactions');
    }
}
