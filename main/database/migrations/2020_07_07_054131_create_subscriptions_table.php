<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->timestamps();
			$table->string('title');
			$table->text('description', 65535);
			$table->decimal('price');
			$table->string('paystack_plan_code');
			$table->string('duration')->nullable();
			$table->string('duration_type')->default('monthly');
			$table->integer('min_orders')->nullable();
			$table->bigInteger('max_orders')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subscriptions');
	}

}
