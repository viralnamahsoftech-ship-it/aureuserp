<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('bm_countries')->cascadeOnDelete();
            $table->string('state_code', 10);
            $table->string('state_name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_states');
    }
};
