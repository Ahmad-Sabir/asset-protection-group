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
        Schema::create('asset_type_work_orders', function (Blueprint $table) {
            $table->foreignId('asset_type_id')->references('id')->on('asset_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('asset_id')->references('id')->on('assets')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('work_order_id')->references('id')->on('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_type_work_orders');
    }
};
