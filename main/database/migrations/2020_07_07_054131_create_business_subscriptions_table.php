<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('business_subscriptions', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('business_id');
			$table->bigInteger('user_id');
			$table->bigInteger('subscription_id');
			$table->string('start_at');
			$table->string('end_at');
			$table->timestamps();
			$table->text('payload', 65535)->nullable();
			$table->bigInteger('totalOrders')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('business_subscriptions');
	}

}
