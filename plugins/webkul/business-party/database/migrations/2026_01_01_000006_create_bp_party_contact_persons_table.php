<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bp_party_contact_persons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id')->constrained('bp_party_masters')->cascadeOnDelete();
            $table->string('site_name', 100)->nullable();
            $table->string('contact_name');
            $table->foreignId('department_id')->nullable()->constrained('bm_departments')->nullOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained('bm_designations')->nullOnDelete();
            $table->string('mobile', 30)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('ext_no', 20)->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_whatsapp')->default(false);
            $table->boolean('auto_mail')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp_party_contact_persons');
    }
};
