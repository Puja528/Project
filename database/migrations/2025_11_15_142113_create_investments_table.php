<?php
// database/migrations/2024_01_01_000005_create_investments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->decimal('initial_amount', 15, 2);
            $table->decimal('current_value', 15, 2);
            $table->decimal('return_amount', 15, 2)->default(0);
            $table->decimal('return_percentage', 8, 2)->default(0);
            $table->date('start_date');
            $table->enum('risk_level', ['low', 'medium', 'high']);
            $table->text('description')->nullable();
            $table->string('symbol')->nullable(); // Untuk saham/reksadana
            $table->integer('quantity')->nullable(); // Jumlah unit/saham
            $table->decimal('average_price', 15, 2)->nullable(); // Harga rata-rata
            $table->enum('status', ['active', 'sold', 'matured'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('investments');
    }
}
