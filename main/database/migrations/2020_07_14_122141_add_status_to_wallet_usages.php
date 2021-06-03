<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToWalletUsages extends Migration
{

    public function up()
    {
        Schema::table('wallet_usage', function (Blueprint $table) {
            $table->string('status')
                ->default('Successful')
                ->after('paying_for');
        });
    }

    public function down()
    {
        Schema::table('wallet_usage', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
