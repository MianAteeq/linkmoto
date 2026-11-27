<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('quotations', 'quotation_time')) {
            Schema::table('quotations', function (Blueprint $table) {
                $table->string('quotation_time', 50)->nullable()->after('quotation_date');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('quotations', 'quotation_time')) {
            Schema::table('quotations', function (Blueprint $table) {
                $table->dropColumn('quotation_time');
            });
        }
    }
};
