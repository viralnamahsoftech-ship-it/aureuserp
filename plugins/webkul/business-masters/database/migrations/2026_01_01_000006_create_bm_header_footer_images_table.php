<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_header_footer_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('bm_company_masters')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('bm_branch_masters')->nullOnDelete();
            $table->enum('image_type', ['header', 'footer']);
            $table->string('file_path', 500);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_header_footer_images');
    }
};
