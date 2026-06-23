<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bm_document_type_masters', function (Blueprint $table) {
            $table->id();
            $table->enum('document_type', ['Vendor Quotation', 'Cust PO', 'Cust Drawing', 'Cust Technical Doc', 'Party Document', 'Our Drawing Doc', 'Our Technical Doc', 'Vendor Other Doc', 'Customer Other Doc']);
            $table->string('sub_doc_type', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bm_document_type_masters');
    }
};
