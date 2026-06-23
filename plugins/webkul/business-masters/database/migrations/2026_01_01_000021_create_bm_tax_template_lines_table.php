<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_tax_template_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_template_id')->constrained('bm_tax_templates')->cascadeOnDelete();
            $table->foreignId('tax_id')->constrained('bm_tax_masters')->cascadeOnDelete();
            $table->decimal('percentage', 8, 4)->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('gl_code', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_tax_template_lines');
    }
};
