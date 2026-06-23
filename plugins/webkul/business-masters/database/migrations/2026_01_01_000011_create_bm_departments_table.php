<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_departments', function (Blueprint $table) {
            $table->id();
            $table->string('dept_name', 100);
            $table->string('dept_code', 20)->nullable();
            $table->foreignId('parent_dept_id')->nullable()->constrained('bm_departments')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_departments');
    }
};
