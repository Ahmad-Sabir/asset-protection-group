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
        Schema::table('work_order_logs', function () {
            if (! App::environment('testing')) {
                DB::statement("ALTER TABLE work_order_logs MODIFY COLUMN `type`
                ENUM(
                    'start',
                    'breakin',
                    'breakout',
                    'end',
                    'custom'
                )
            ");
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! App::environment('testing')) {
            DB::statement("ALTER TABLE work_order_logs MODIFY COLUMN `type`
            ENUM(
                'start',
                'breakin',
                'breakout',
                'end',
                'custom'
            )
        ");
        }
    }
};
