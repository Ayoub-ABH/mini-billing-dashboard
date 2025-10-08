<?php

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
        // Define the invoices table schema
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            // Foreign key relation to the customer table
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');

            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('amount', 10, 2); // Store currency amounts accurately
            $table->enum('status', ['Pending', 'Paid', 'Void', 'Late'])->default('Pending');
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
