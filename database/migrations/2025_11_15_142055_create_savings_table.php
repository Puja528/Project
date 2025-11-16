<?php
// database/migrations/2024_01_01_000010_create_savings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingsTable extends Migration
{
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('target_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->date('target_date');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->string('color')->default('#3B82F6'); // Warna untuk chart
            $table->string('icon')->default('piggy-bank'); // Icon untuk tampilan
            $table->decimal('monthly_target', 15, 2)->nullable(); // Target bulanan otomatis
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('savings');
    }
}
