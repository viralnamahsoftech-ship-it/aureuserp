<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_sub_company_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('bm_company_masters')->cascadeOnDelete();
            $table->string('sub_company_code', 20)->unique();
            $table->string('sub_company_name');
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_sub_company_masters');
    }
};
