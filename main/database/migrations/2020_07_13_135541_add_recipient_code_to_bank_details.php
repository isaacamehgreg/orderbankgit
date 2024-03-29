<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecipientCodeToBankDetails extends Migration
{

    public function up()
    {
        Schema::table('bank_details', function (Blueprint $table) {
            $table->string('recipient_code')->nullable();
        });
    }

    public function down()
    {
        Schema::table('bank_details', function (Blueprint $table) {
            $table->dropColumn('recipient_code');
        });
    }
}
