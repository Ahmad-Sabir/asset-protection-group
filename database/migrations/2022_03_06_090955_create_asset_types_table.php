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
        Schema::create('asset_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name', 110);
            $table->enum('type', [config('apg.type.master'), config('apg.type.company')])->default(config('apg.type.master'));
            $table->softDeletes();
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
        Schema::dropIfExists('asset_types');
    }
};
