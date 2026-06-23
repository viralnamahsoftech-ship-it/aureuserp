<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_designations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained('bm_departments')->nullOnDelete();
            $table->string('designation_name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_designations');
    }
};
