<?php
// database/migrations/2024_01_01_000006_create_produks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);
            $table->integer('stok')->default(0);
            $table->string('kategori')->nullable();
            $table->string('satuan')->nullable();
            $table->string('barcode')->nullable()->unique();
            $table->string('gambar')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produks');
    }
}
