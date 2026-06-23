<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained('bm_states')->cascadeOnDelete();
            $table->string('city_name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_cities');
    }
};
