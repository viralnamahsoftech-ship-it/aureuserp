<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_doc_wise_send_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('bm_company_masters')->cascadeOnDelete();
            $table->string('document_type', 100);
            $table->boolean('send_via_email')->default(false);
            $table->boolean('send_via_whatsapp')->default(false);
            $table->text('email_template')->nullable();
            $table->text('whatsapp_template')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_doc_wise_send_details');
    }
};
