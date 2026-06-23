<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads_leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_number')->unique();
            $table->string('business_name');
            $table->string('contact_title')->nullable();
            $table->string('contact_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('alternate_phone')->nullable();
            $table->string('business_segment')->nullable();
            $table->string('business_category')->nullable();
            $table->string('business_sub_category')->nullable();
            $table->string('stage')->default('new');
            $table->string('priority')->default('medium');
            $table->string('source')->nullable();
            $table->string('other_source')->nullable();
            $table->string('project_title')->nullable();
            $table->text('description')->nullable();
            $table->text('remarks')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('site_contact_name')->nullable();
            $table->string('site_contact_phone')->nullable();
            $table->string('site_address_line_1')->nullable();
            $table->string('site_address_line_2')->nullable();
            $table->string('site_city')->nullable();
            $table->string('site_state')->nullable();
            $table->string('site_zip')->nullable();
            $table->string('gst_number')->nullable();
            $table->decimal('pv_capacity', 15, 2)->nullable();
            $table->decimal('expected_value', 15, 2)->nullable();
            $table->unsignedTinyInteger('probability')->default(0);
            $table->date('expected_close_date')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamp('next_follow_up_at')->nullable();
            $table->string('lost_reason')->nullable();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('partners_partners')
                ->nullOnDelete();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->restrictOnDelete();

            $table->foreignId('creator_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['stage', 'priority']);
            $table->index(['assigned_to', 'next_follow_up_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads_leads');
    }
};
