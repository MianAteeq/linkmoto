<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trading_unit_app_settings', function (Blueprint $table) {
            $table->string('show_landline')->default('No');
            $table->string('show_mobile')->default('No')->after('show_landline');
            $table->string('show_email')->default('No')->after('show_mobile');
            $table->string('show_website')->default('No')->after('show_email');
            $table->string('is_payment_reference')->default('No')->after('show_email');
            $table->string('show_remittance_email')->default('No')->after('show_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trading_unit_app_settings', function (Blueprint $table) {
            $table->dropColumn(['show_landline', 'show_mobile', 'show_email', 'show_website', 'is_payment_reference', 'show_remittance_email']);
        });
    }
};
