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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id')->nullable();
            $table->text('description');
            $table->text('type');
            $table->integer('amount');
            $table->boolean('approved');
            $table->boolean('needs_review');
            $table->timestamps();

            $table
                ->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
