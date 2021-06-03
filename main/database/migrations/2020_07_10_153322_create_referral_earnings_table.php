<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralEarningsTable extends Migration
{
    public function up()
    {
        Schema::create('referral_earnings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('referrer_id');
            $table->unsignedInteger('origin_transaction_id');
            $table->string('reference');
            $table->string('description');
            $table->decimal('amount_earned', 19, 4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('referral_earnings');
    }
}
