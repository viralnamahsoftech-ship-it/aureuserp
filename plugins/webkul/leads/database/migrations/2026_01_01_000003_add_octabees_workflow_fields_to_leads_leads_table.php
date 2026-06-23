<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads_leads', function (Blueprint $table) {
            if (! Schema::hasColumn('leads_leads', 'lead_date')) {
                $table->date('lead_date')->nullable()->after('lead_number');
            }

            if (! Schema::hasColumn('leads_leads', 'process_status')) {
                $table->string('process_status')->default('pending')->after('other_source')->index();
            }

            if (! Schema::hasColumn('leads_leads', 'progress_status')) {
                $table->string('progress_status')->default('new')->after('process_status')->index();
            }

            if (! Schema::hasColumn('leads_leads', 'user_state')) {
                $table->string('user_state')->default('active')->after('progress_status')->index();
            }

            if (! Schema::hasColumn('leads_leads', 'location')) {
                $table->string('location')->nullable()->after('country');
            }

            if (! Schema::hasColumn('leads_leads', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('location');
            }

            if (! Schema::hasColumn('leads_leads', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }

            if (! Schema::hasColumn('leads_leads', 'territory')) {
                $table->string('territory')->nullable()->after('lost_reason');
            }

            if (! Schema::hasColumn('leads_leads', 'account_manager_id')) {
                $table->foreignId('account_manager_id')
                    ->nullable()
                    ->after('territory')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('leads_leads', 'channel_partner_id')) {
                $table->foreignId('channel_partner_id')
                    ->nullable()
                    ->after('account_manager_id')
                    ->constrained('partners_partners')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('leads_leads', 'sales_person_ids')) {
                $table->json('sales_person_ids')->nullable()->after('channel_partner_id');
            }

            if (! Schema::hasColumn('leads_leads', 'products')) {
                $table->json('products')->nullable()->after('sales_person_ids');
            }
        });
    }

    public function down(): void
    {
        Schema::table('leads_leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads_leads', 'channel_partner_id')) {
                $table->dropConstrainedForeignId('channel_partner_id');
            }

            if (Schema::hasColumn('leads_leads', 'account_manager_id')) {
                $table->dropConstrainedForeignId('account_manager_id');
            }

            foreach ([
                'products',
                'sales_person_ids',
                'territory',
                'longitude',
                'latitude',
                'location',
                'user_state',
                'progress_status',
                'process_status',
                'lead_date',
            ] as $column) {
                if (Schema::hasColumn('leads_leads', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
