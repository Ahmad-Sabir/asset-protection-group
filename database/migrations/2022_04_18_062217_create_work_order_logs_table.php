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
        Schema::create('work_order_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->nullable()->references('id')->on('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('parent_id')->nullable();
            $table->timestamp('time')->nullable();
            $table->enum('type', config('apg.log_status'))->default(config('apg.log_status.start'));
            $table->time('total_log')->nullable();
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
        Schema::dropIfExists('work_order_logs');
    }
};
