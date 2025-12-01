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
        Schema::create('debt', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['piutang', 'hutang']);
            $table->string('person_name');
            $table->decimal('amount', 15, 2); // Pastikan kolom amount ada
            $table->decimal('initial_amount', 15, 2);
            $table->date('due_date');
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->enum('status', ['active', 'paid', 'overdue'])->default('active');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt');
    }
};
