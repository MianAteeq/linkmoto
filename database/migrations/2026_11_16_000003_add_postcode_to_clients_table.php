<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('clients', 'postcode')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->string('postcode', 16)->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('postcode');
        });
    }
};
