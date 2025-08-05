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
        Schema::create('cash_book', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->string('description');
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 10, 2);
            $table->string('category')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('payment_method')->default('cash');
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            $table->index('transaction_date');
            $table->index('type');
            $table->index('category');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_book');
    }
};