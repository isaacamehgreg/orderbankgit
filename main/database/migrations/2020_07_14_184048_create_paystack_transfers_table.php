<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaystackTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('paystack_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('wallet_usage_id');
            $table->string('reference');
            $table->string('status');
            $table->string('transfer_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paystack_transfers');
    }
}
