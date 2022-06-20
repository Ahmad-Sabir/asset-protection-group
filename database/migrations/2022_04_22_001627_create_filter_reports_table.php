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
        Schema::create('filter_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', [
                config('apg.report_types.assets'),
                config('apg.report_types.work_orders'),
                config('apg.report_types.users'),
            ]);
            $table->json('filter')->nullable();
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
        Schema::dropIfExists('filter_reports');
    }
};
