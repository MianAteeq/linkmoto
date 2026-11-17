<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('general');
            $table->string('status_word')->nullable();
            $table->string('status_color')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('tru_id')->nullable();
            $table->string('related_entity_id')->nullable();
            $table->string('related_entity_type')->nullable();
            $table->string('action_label')->nullable();
            $table->string('action_route')->nullable();
            $table->json('action_params')->nullable();
            $table->timestamp('read_at')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_notifications');
    }
};

