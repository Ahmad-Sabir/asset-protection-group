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
        Schema::create('asset_medias', function (Blueprint $table) {
            $table->foreignId('asset_id')->references('id')->on('assets')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('media_id')->references('id')->on('medias')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_medias');
    }
};
