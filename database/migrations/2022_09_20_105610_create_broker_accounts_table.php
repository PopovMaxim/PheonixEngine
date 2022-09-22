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
        Schema::create('broker_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('account_name');
            $table->string('account_company');
            $table->string('account_number')->unique();
            $table->string('ea_name');
            $table->string('ea_version');
            $table->string('status')->default(0);
            $table->timestamp('expires_at');
            $table->softDeletes($column = 'deleted_at');
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
        Schema::dropIfExists('broker_accounts');
    }
};
