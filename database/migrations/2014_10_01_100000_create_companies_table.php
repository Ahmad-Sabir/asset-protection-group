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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_media_id')->nullable()->references('id')->on('medias')->cascadeOnUpdate()->nullOnDelete();
            $table->string('manager_first_name');
            $table->string('manager_last_name');
            $table->string('name');
            $table->string('designation');
            $table->string('manager_email');
            $table->string('manager_phone', 20);
            $table->timestamp('deactivate_at')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
