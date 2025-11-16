<?php
// database/migrations/2024_01_01_000004_create_debts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['hutang', 'piutang']);
            $table->string('person_name');
            $table->decimal('amount', 15, 2);
            $table->decimal('initial_amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->date('due_date');
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'paid', 'overdue'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('debts');
    }
}
