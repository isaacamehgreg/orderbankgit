<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferenceToWalletUsage extends Migration
{

    public function up()
    {
        Schema::table('wallet_usage', function (Blueprint $table) {
            $table->string('reference')
                ->nullable()
                ->after('status');
        });
    }

    public function down()
    {
        Schema::table('wallet_usage', function (Blueprint $table) {
            $table->dropColumn('reference');
        });
    }
}
