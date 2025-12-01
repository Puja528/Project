<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budget', function (Blueprint $table) {
            $table->id();
            $table->string('budget_name');
            $table->enum('category', [
                'makanan',
                'transportasi',
                'hiburan',
                'kesehatan',
                'pendidikan',
                'belanja',
                'tagihan',
                'investasi',
                'lainnya'
            ]);
            $table->date('period'); // Menyimpan sebagai date (YYYY-MM-01)
            $table->decimal('allocated_amount', 15, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budget');
    }
};
