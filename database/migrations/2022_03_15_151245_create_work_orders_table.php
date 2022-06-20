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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('assignee_user_id')->nullable()->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->references('id')->on('locations')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('asset_id')->nullable()->references('id')->on('assets')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('asset_type_id')->nullable()->references('id')->on('asset_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('work_order_profile_id')->nullable()->references('id')->on('medias')->cascadeOnUpdate()->nullOnDelete();
            $table->text('qualification')->nullable();
            $table->string('title', 225);
            $table->text('description')->nullable();
            $table->text('additional_info')->nullable();
            $table->enum('flag', config('apg.flag'))->default('off');
            $table->enum('priority', config('apg.priority'))->default('Low');
            $table->enum('type', [config('apg.type.master'), config('apg.type.company')])->default(config('apg.type.master'));
            $table->enum('work_order_type', config('apg.work_order_type'))->default('Non Recurring');
            $table->enum('work_order_frequency', config('apg.frequency'))->nullable();
            $table->enum('work_order_status', config('apg.work_order_status'))->default('Open');
            $table->string('work_order_log_timer', 225)->nullable();
            $table->date('due_date')->nullable();
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
        Schema::dropIfExists('work_orders');
    }
};
