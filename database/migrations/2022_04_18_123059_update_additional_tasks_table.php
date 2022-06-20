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
        Schema::table('additional_tasks', function (Blueprint $table) {
            $table->foreignId('work_order_id')->nullable()->references('id')->on('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('additional_tasks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('work_order_id');
        });
    }
};
