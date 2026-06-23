<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lead_id')
                ->constrained('leads_leads')
                ->cascadeOnDelete();

            $table->string('type')->default('note');
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->timestamp('activity_at')->nullable();

            $table->foreignId('creator_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads_activities');
    }
};
