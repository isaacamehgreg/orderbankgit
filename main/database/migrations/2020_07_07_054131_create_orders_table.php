<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('business_id')->nullable();
			$table->integer('creator_id')->nullable();
			$table->string('invoice');
			$table->string('sender');
			$table->integer('customer_id');
			$table->string('delivery_status')->nullable();
			$table->text('comment', 65535)->nullable();
			$table->string('delivery_time')->nullable();
			$table->string('remittedvalue')->nullable();
			$table->integer('form_id')->nullable();
			$table->string('product_id');
			$table->string('product_qty');
			$table->string('product_total_price');
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
		Schema::drop('orders');
	}

}
