<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankDetailsTable extends Migration
{

    public function up()
    {
        Schema::create('bank_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('nuban', 15);
            $table->string('account_name');
            $table->string('bank_code', 10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_details');
    }
}
