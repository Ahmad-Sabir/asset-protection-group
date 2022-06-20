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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->references('id')->on('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->enum('type', ['employee-payment', 'maintenance-material'])->default('employee-payment');
            $table->decimal('amount');
            $table->date('expense_date');
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
        Schema::dropIfExists('expenses');
    }
};
