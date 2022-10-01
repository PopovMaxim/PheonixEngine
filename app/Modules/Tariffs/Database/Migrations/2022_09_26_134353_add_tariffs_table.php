<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->integer('tariff_line');
            $table->string('key')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->integer('priority')->default(0);
            $table->string('period')->nullable();
            $table->string('color')->nullable();
            $table->json('marketing')->nullable();
            $table->json('ribbon')->nullable();
            $table->json('sale')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariffs');
    }
};
