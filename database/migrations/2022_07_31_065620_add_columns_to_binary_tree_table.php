<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('binary_tree', function (Blueprint $table) {
            $table->integer('total_value')->default(0);
            $table->integer('residue_value_left_leg')->default(0);
            $table->integer('residue_value_right_leg')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('binary_tree', function (Blueprint $table) {
            $table->dropColumn(['total_value', 'residue_value_left_leg', 'residue_value_right_leg']);
        });
    }
};
