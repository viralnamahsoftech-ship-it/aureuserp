<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bp_item_main_sub_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name', 100);
            $table->enum('group_type', ['Main', 'Sub', 'Other'])->default('Main');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp_item_main_sub_groups');
    }
};
