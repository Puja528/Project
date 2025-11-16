<?php
// database/migrations/2024_01_01_000002_add_missing_columns_to_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('amount', 15, 2)->after('user');
            $table->enum('type', ['income', 'expense'])->after('amount');
            $table->string('category')->after('type');
            $table->date('date')->after('category');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['amount', 'type', 'category', 'date']);
        });
    }
}
