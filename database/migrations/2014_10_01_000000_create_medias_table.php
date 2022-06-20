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
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('width');
            $table->integer('height');
            $table->string('hash');
            $table->decimal('size', 8, 2);
            $table->text('url');
            $table->string('ext');
            $table->tinyInteger('is_internal_file');
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
        Schema::dropIfExists('medias');
    }
};
