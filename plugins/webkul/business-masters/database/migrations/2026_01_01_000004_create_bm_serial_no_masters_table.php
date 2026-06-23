<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_serial_no_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('bm_company_masters')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('bm_branch_masters')->nullOnDelete();
            $table->string('doc_type', 100);
            $table->string('prefix', 20)->nullable();
            $table->string('suffix', 20)->nullable();
            $table->string('separator', 5)->default('/');
            $table->unsignedInteger('current_no')->default(0);
            $table->tinyInteger('pad_length')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['company_id', 'branch_id', 'doc_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_serial_no_masters');
    }
};
