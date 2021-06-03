<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWaybillTrackingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('waybill_trackings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('waybill_id');
			$table->string('waybill_code');
			$table->string('status');
			$table->string('desc');
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
		Schema::drop('waybill_trackings');
	}

}
