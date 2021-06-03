<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWaybillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('waybills', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('creator_id');
			$table->integer('courier_id');
			$table->string('waybill_code');
			$table->string('sender');
			$table->integer('recipient_id');
			$table->string('date_of_shipment');
			$table->string('payment_method');
			$table->string('shipment_type');
			$table->string('shipping_fee');
			$table->string('delivery_status')->nullable();
			$table->string('reference_number')->nullable();
			$table->integer('packages_count');
			$table->string('packages_item_name');
			$table->string('packages_item_qty');
			$table->string('packages_item_unit_price');
			$table->string('packages_item_total_price');
			$table->string('packages_weight');
			$table->timestamps();
			$table->string('created_date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('waybills');
	}

}
