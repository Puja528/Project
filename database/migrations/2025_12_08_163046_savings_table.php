<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('target_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->date('target_date');
            $table->text('description')->nullable();
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->timestamps();

            $table->index(['user_id', 'target_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('savings');
    }
};
