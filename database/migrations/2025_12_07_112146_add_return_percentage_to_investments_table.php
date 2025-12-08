<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('investment', function (Blueprint $table) {
            $table->decimal('return_percentage', 8, 2)->nullable()->after('current_value');
        });
    }

    public function down()
    {
        Schema::table('investment', function (Blueprint $table) {
            $table->dropColumn('return_percentage');
        });
    }
};
