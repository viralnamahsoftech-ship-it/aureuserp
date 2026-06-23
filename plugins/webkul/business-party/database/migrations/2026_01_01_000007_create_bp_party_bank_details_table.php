<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bp_party_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id')->constrained('bp_party_masters')->cascadeOnDelete();
            $table->string('bank_name');
            $table->string('account_name')->nullable();
            $table->string('account_no', 50)->nullable();
            $table->string('account_type', 50)->nullable();
            $table->string('ifsc_code', 20)->nullable();
            $table->string('ocr_no', 50)->nullable();
            $table->string('icri_number', 50)->nullable();
            $table->string('branch_name')->nullable();
            $table->text('branch_address')->nullable();
            $table->string('branch_code', 20)->nullable();
            $table->boolean('is_whatsapp')->default(false);
            $table->boolean('auto_mail')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp_party_bank_details');
    }
};
