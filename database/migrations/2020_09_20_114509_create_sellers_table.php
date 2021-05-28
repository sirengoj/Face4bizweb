<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('f_name', 30)->nullable();
            $table->string('l_name', 30)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('image', 50)->default('def.png');
            $table->string('email', 80)->unique();
            $table->string('password', 80)->nullable();
            $table->string('status', 15)->default('pending');
            $table->rememberToken();
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
        Schema::dropIfExists('sellers');
    }
}
