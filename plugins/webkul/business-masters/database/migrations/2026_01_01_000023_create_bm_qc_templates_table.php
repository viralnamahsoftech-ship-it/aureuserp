<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_qc_templates', function (Blueprint $table) {
            $table->id();
            $table->string('qc_temp_code', 30)->unique();
            $table->string('qc_temp_name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_qc_templates');
    }
};
