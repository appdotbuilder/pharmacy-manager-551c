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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('markup_percentage', 5, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->integer('minimum_stock')->default(10);
            $table->string('unit')->default('pcs');
            $table->boolean('requires_prescription')->default(false);
            $table->date('expiry_date')->nullable();
            $table->string('batch_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('sku');
            $table->index('barcode');
            $table->index('category_id');
            $table->index('stock_quantity');
            $table->index('expiry_date');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};