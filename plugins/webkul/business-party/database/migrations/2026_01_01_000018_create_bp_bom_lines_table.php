<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bp_bom_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_id')->constrained('bp_bom_masters')->cascadeOnDelete();
            $table->foreignId('component_id')->constrained('bp_item_masters')->cascadeOnDelete();
            $table->foreignId('process_id')->nullable()->constrained('bp_process_masters')->nullOnDelete();
            $table->decimal('qty', 15, 4)->default(1);
            $table->foreignId('uom_id')->nullable()->constrained('bp_uoms')->nullOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp_bom_lines');
    }
};
