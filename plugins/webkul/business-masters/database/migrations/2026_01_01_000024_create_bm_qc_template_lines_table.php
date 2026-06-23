<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_qc_template_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qc_template_id')->constrained('bm_qc_templates')->cascadeOnDelete();
            $table->foreignId('qc_parameter_id')->constrained('bm_qc_parameters')->cascadeOnDelete();
            $table->decimal('min_value', 15, 4)->nullable();
            $table->decimal('max_value', 15, 4)->nullable();
            $table->enum('result_type', ['Yes', 'No', 'Value'])->default('Value');
            $table->tinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_qc_template_lines');
    }
};
