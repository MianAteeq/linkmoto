<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_streams', function (Blueprint $table) {
            $table->id();
            $table->integer('trading_id')->nullable();
            $table->integer('vender_id')->nullable();
            $table->string('Workstream_name')->nullable();
            $table->string('status')->default('INACTIVE');
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
        Schema::dropIfExists('work_streams');
    }
};
