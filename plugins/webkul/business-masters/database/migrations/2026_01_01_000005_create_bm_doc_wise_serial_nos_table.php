<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_doc_wise_serial_nos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('bm_company_masters')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('bm_branch_masters')->nullOnDelete();
            $table->string('document_type', 100);
            $table->foreignId('serial_no_id')->nullable()->constrained('bm_serial_no_masters')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_doc_wise_serial_nos');
    }
};
