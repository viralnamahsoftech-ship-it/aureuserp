<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_tax_masters', function (Blueprint $table) {
            $table->id();
            $table->string('tax_code', 20)->unique();
            $table->string('tax_name', 100);
            $table->decimal('percentage', 8, 4)->default(0);
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('gl_code', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_tax_masters');
    }
};
