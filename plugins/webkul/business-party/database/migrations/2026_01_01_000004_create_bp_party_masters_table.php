<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bp_party_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('bm_company_masters')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('bm_branch_masters')->nullOnDelete();
            $table->string('party_code', 30);
            $table->string('party_name');
            $table->foreignId('party_type_id')->nullable()->constrained('bp_party_types')->nullOnDelete();
            $table->foreignId('party_group_id')->nullable()->constrained('bp_party_groups')->nullOnDelete();
            $table->foreignId('industry_type_id')->nullable()->constrained('bp_industry_types')->nullOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('bm_currencies')->nullOnDelete();
            $table->text('ho_address')->nullable();
            $table->foreignId('city_id')->nullable()->constrained('bm_cities')->nullOnDelete();
            $table->foreignId('state_id')->nullable()->constrained('bm_states')->nullOnDelete();
            $table->foreignId('country_id')->nullable()->constrained('bm_countries')->nullOnDelete();
            $table->string('pincode', 20)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('email')->nullable();
            $table->enum('gst_supply_type', ['InterState', 'IntraState', 'Export', 'Import'])->nullable();
            $table->enum('tax_on', ['ItemWise', 'InvoiceBased'])->nullable();
            $table->string('gstin', 30)->nullable();
            $table->string('pan_no', 20)->nullable();
            $table->string('ecc_no', 30)->nullable();
            $table->string('uan_no', 30)->nullable();
            $table->string('tin_no', 30)->nullable();
            $table->string('msme_no', 30)->nullable();
            $table->enum('msme_type', ['High', 'Middle', 'Small'])->nullable();
            $table->string('udaid_no', 30)->nullable();
            $table->string('other_ref_no', 100)->nullable();
            $table->decimal('op_bal', 15, 2)->default(0);
            $table->enum('op_bal_type', ['Dr', 'Cr'])->nullable();
            $table->unsignedBigInteger('account_group_id')->nullable();
            $table->boolean('is_tds_applicable')->default(false);
            $table->unsignedBigInteger('tds_payment_id')->nullable();
            $table->string('gl_tds_code', 50)->nullable();
            $table->decimal('credit_limit', 15, 2)->nullable();
            $table->boolean('allow_multiple_invoice')->default(false);
            $table->boolean('is_parent_party')->default(false);
            $table->foreignId('parent_party_id')->nullable()->constrained('bp_party_masters')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->unique(['company_id', 'branch_id', 'party_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp_party_masters');
    }
};
