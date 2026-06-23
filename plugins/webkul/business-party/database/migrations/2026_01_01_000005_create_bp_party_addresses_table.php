<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bp_party_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id')->constrained('bp_party_masters')->cascadeOnDelete();
            $table->string('site_name', 100)->nullable();
            $table->enum('address_type', ['Billing', 'Delivery', 'Both']);
            $table->text('address')->nullable();
            $table->foreignId('city_id')->nullable()->constrained('bm_cities')->nullOnDelete();
            $table->foreignId('state_id')->nullable()->constrained('bm_states')->nullOnDelete();
            $table->string('state_code', 10)->nullable();
            $table->foreignId('country_id')->nullable()->constrained('bm_countries')->nullOnDelete();
            $table->string('pincode', 20)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('gstin', 30)->nullable();
            $table->boolean('is_whatsapp')->default(false);
            $table->boolean('auto_mail')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp_party_addresses');
    }
};
