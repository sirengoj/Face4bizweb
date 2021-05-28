<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketConvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_ticket_convs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('support_ticket_id')->nullable();
            $table->bigInteger('admin_id')->nullable();
            $table->string('customer_message')->nullable();
            $table->string('admin_message')->nullable();
            $table->integer('position')->default(0);
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
        Schema::dropIfExists('support_ticket_convs');
    }
}
