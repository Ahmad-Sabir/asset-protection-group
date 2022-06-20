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
        Schema::create('additional_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('task_detail');
            $table->enum('status', config('apg.task_status'))->default('Pending');
            $table->date('due_date');
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
        Schema::dropIfExists('additional_tasks');
    }
};
