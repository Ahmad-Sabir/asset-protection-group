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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('location_id')
                ->nullable()
                ->references('id')
                ->on('locations')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('asset_type_id')
                ->nullable()
                ->references('id')
                ->on('asset_types')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name', 110);
            $table->string('model', 110)->nullable();
            $table->mediumText('manufacturer')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', [config('apg.type.master'), config('apg.type.company')])->default('master');
            $table->decimal('purchase_price')->nullable();
            $table->decimal('replacement_cost')->nullable();
            $table->json('custom_values')->nullable();
            $table->json('total_useful_life')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->date('purchase_date')->nullable();
            $table->date('installation_date')->nullable();
            $table->date('warranty_expiry_date')->nullable();
            $table->date('total_useful_life_date')->nullable();
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
        Schema::dropIfExists('assets');
    }
};
