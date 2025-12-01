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
        Schema::create('investment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->enum('risk_level', ['low', 'medium', 'high']);
            $table->decimal('initial_amount', 15, 2);
            $table->decimal('current_value', 15, 2);
            $table->date('start_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('investment');
    }
};