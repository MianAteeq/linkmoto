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
        Schema::create('agreementag_acceptances', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');

            $table->string('agreement_type');
            $table->string('agreement_version');

            $table->string('user_full_name');
            $table->string('user_email');
            $table->string('user_role');

            $table->string('service_provider_name');

            $table->string('acceptance_method'); // Service Provider App
            $table->ipAddress('ip_address');

            $table->timestamp('accepted_at');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreementag_acceptances');
    }
};
