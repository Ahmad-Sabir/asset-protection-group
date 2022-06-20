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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('profile_media_id')->nullable()->references('id')->on('medias')->cascadeOnUpdate()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->enum('user_status', [
                config('apg.user_status.super-admin'),
                config('apg.user_status.admin'),
                config('apg.user_status.employee')
            ])->default(config('apg.user_status.employee'));
            $table->tinyInteger('is_update_password')->default(0);
            $table->decimal('per_hour_rate')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
