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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('motorcycle_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->date('start_date');
            $table->date('estimated_return_date');
            $table->date('actual_return_date')->nullable();
            $table->unsignedInteger('total_rent_days');
            $table->decimal('total_rent_price', 12, 2);
            $table->unsignedInteger('late_days')->nullable();
            $table->decimal('late_fee', 12, 2)->nullable();
            $table->decimal('additional_fee', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->enum('status', ['ongoing', 'completed', 'cancelled'])->default('ongoing')->index();
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();

            $table->index(['start_date', 'estimated_return_date', 'motorcycle_id', 'status'], 'rentals_calendar_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
