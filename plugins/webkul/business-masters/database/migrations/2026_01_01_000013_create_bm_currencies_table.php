<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code', 10)->unique();
            $table->string('currency_name', 100);
            $table->decimal('conv_rate', 15, 6)->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_currencies');
    }
};
