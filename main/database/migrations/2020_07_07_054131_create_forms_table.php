<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('business_id')->nullable();
			$table->string('title');
			$table->string('desc')->nullable();
			$table->string('products');
			$table->string('link')->nullable();
			$table->string('redirect')->nullable();
			$table->string('views')->nullable();
			$table->timestamps();
			$table->integer('whatsapp_number_id')->nullable();
			$table->text('delivery_times', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forms');
	}

}
