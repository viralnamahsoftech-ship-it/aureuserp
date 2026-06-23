<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bp_hsn_masters', function (Blueprint $table) {
            $table->id();
            $table->string('hsn_no', 50)->unique();
            $table->string('hsn_desc')->nullable();
            $table->decimal('sgst', 8, 4)->nullable();
            $table->decimal('cgst', 8, 4)->nullable();
            $table->decimal('igst', 8, 4)->nullable();
            $table->string('psgt_gl', 50)->nullable();
            $table->string('pcgt_gl', 50)->nullable();
            $table->string('pigt_gl', 50)->nullable();
            $table->string('ssgt_gl', 50)->nullable();
            $table->string('scgt_gl', 50)->nullable();
            $table->string('sigt_gl', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp_hsn_masters');
    }
};
