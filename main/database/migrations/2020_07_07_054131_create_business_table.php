<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('business', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('business_name')->nullable();
			$table->string('business_logo')->nullable();
			$table->string('business_address')->nullable();
			$table->string('business_phone_number')->nullable();
			$table->string('business_email')->nullable();
			$table->integer('user_id')->nullable();
			$table->timestamps();
			$table->string('firstname')->nullable();
			$table->string('_lastname')->nullable();
			$table->string('lastname')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('business');
	}

}
