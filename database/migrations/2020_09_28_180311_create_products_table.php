<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('added_by')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('name', 80)->nullable();
            $table->string('slug', 120)->nullable();
            $table->string('category_ids', 80)->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('unit')->nullable();
            $table->integer('min_qty')->default(1);
            $table->boolean('refundable')->default(1);
            $table->string('images', 255)->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->string('featured', 255)->nullable();
            $table->string('flash_deal', 255)->nullable();
            $table->string('video_provider', 30)->nullable();
            $table->string('video_url', 150)->nullable();

            $table->string('colors', 150)->nullable();
            $table->boolean('variant_product')->default(0);
            $table->string('attributes', 255)->nullable();
            $table->text('choice_options')->nullable();
            $table->text('variation')->nullable();
            $table->boolean('published')->default(0);

            $table->decimal('unit_price')->default(0);
            $table->decimal('purchase_price')->default(0);
            $table->decimal('tax')->default(0);
            $table->string('tax_type', 80)->nullable();
            $table->decimal('discount')->default(0);
            $table->string('discount_type', 80)->nullable();
            $table->integer('current_stock')->nullable();
            $table->text('details')->nullable();
            $table->boolean('free_shipping')->default(0);
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('products');
    }
}
