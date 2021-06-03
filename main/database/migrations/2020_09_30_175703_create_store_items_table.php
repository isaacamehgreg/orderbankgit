<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_items', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('store_id');
            $table->string('item_name');
            $table->text('item_headline');
            $table->string('item_featured_image');
            $table->text('item_sub_headline');
            $table->text('item_description');
            $table->string('item_image_1')->nullable();
            $table->string('item_image_2')->nullable();
            $table->string('item_image_3')->nullable();
            $table->string('item_image_4')->nullable();
            $table->decimal('item_amount')->default(0.00);
            $table->integer('form_id');
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
        Schema::dropIfExists('store_items');
    }
}
