<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_stage_masters', function (Blueprint $table) {
            $table->id();
            $table->enum('form_name', ['Lead', 'Quotation', 'Sales Order', 'Proforma Invoice', 'Sales Invoice', 'Purchase Order', 'Purchase Invoice']);
            $table->string('stage_name', 100);
            $table->text('details')->nullable();
            $table->tinyInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_stage_masters');
    }
};
