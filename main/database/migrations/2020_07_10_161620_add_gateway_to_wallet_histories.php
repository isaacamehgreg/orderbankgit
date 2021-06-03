<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGatewayToWalletHistories extends Migration
{
    public function up()
    {
        Schema::table('wallet_histories', function (Blueprint $table) {
            $table->string('gateway')->after('status')
                ->default("Paystack");
        });
    }

    public function down()
    {
        Schema::table('wallet_histories', function (Blueprint $table) {
            $table->dropColumn('gateway');
        });
    }
}
