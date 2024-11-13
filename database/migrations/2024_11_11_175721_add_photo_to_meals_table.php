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
        Schema::table('meals', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('price'); // Add 'photo' column after 'price'
        });
    }

    public function down()
    {
        Schema::table('meals', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
};
