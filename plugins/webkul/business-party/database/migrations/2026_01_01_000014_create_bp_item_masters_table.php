<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bp_item_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('bm_company_masters')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('bm_branch_masters')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('bp_item_categories')->nullOnDelete();
            $table->foreignId('item_group_id')->nullable()->constrained('bp_item_groups')->nullOnDelete();
            $table->string('item_code', 30);
            $table->string('item_name');
            $table->enum('item_type', ['Sales', 'Purchase', 'Service', 'General']);
            $table->enum('process_type', ['Procured', 'Manufacture']);
            $table->foreignId('uom_id')->nullable()->constrained('bp_uoms')->nullOnDelete();
            $table->foreignId('purch_uom_id')->nullable()->constrained('bp_uoms')->nullOnDelete();
            $table->foreignId('sales_uom_id')->nullable()->constrained('bp_uoms')->nullOnDelete();
            $table->decimal('conv_qty', 15, 4)->default(1);
            $table->decimal('purch_conv_qty', 15, 4)->default(1);
            $table->decimal('sales_conv_qty', 15, 4)->default(1);
            $table->text('detail_desc')->nullable();
            $table->string('drawing_no', 100)->nullable();
            $table->string('drawing_rev_no', 100)->nullable();
            $table->string('part_no', 100)->nullable();
            $table->foreignId('main_group_id')->nullable()->constrained('bp_item_main_sub_groups')->nullOnDelete();
            $table->foreignId('sub_group_id')->nullable()->constrained('bp_item_main_sub_groups')->nullOnDelete();
            $table->foreignId('other_group_id')->nullable()->constrained('bp_item_main_sub_groups')->nullOnDelete();
            $table->boolean('qc_required')->default(false);
            $table->boolean('qc_param_required')->default(false);
            $table->string('location', 100)->nullable();
            $table->text('internal_remarks')->nullable();
            $table->string('make', 100)->nullable();
            $table->string('serial_no_code', 100)->nullable();
            $table->decimal('min_stock', 15, 4)->nullable();
            $table->decimal('moq', 15, 4)->nullable();
            $table->unsignedInteger('lead_time')->nullable();
            $table->string('class_name', 100)->nullable();
            $table->boolean('manual_trans')->default(false);
            $table->decimal('tolerance_plus', 8, 4)->nullable();
            $table->decimal('tolerance_minus', 8, 4)->nullable();
            $table->decimal('max_qty', 15, 4)->nullable();
            $table->decimal('max_order_qty', 15, 4)->nullable();
            $table->decimal('reorder_qty', 15, 4)->nullable();
            $table->boolean('grn_required')->default(false);
            $table->boolean('material_provide')->default(false);
            $table->decimal('size_packet_qty', 15, 4)->nullable();
            $table->unsignedInteger('self_life')->nullable();
            $table->unsignedInteger('warranty_period')->nullable();
            $table->foreignId('hsn_id')->nullable()->constrained('bp_hsn_masters')->nullOnDelete();
            $table->string('acct_gl_code', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('batch_wise')->default(false);
            $table->boolean('serial_no_wise')->default(false);
            $table->boolean('account_effect')->default(false);
            $table->boolean('is_stock_effect')->default(false);
            $table->enum('planning', ['Against Order', 'Cumulative', 'Both'])->nullable();
            $table->enum('gst_on', ['ItemWise', 'InvoiceBased'])->nullable();
            $table->enum('gst_supply_type', ['InterState', 'IntraState', 'Export', 'Import'])->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->unique(['company_id', 'branch_id', 'item_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp_item_masters');
    }
};
