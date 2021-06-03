<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->string('store_url_slug');
            $table->string('store_title');
            $table->string('store_header_color')->default('#5E2CED');
            $table->string('store_font_color')->default('#000');
            $table->string('store_footer_color')->default('#5E2CED');
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
        Schema::dropIfExists('stores');
    }
}
