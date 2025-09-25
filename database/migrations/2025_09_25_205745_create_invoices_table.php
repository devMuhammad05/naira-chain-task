<?php

use App\Enums\InvoiceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->text('description')->nullable();
            $table->string('billing_name');
            $table->string('billing_email')->nullable();
            $table->string('billing_address')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->date('due_date')->nullable();
            $table->date('issue_date');
            $table->string('status')->default(InvoiceStatus::Draft);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
