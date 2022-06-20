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
        Schema::table('work_orders', function () {
            if (! App::environment('testing')) {
                DB::statement("ALTER TABLE work_orders MODIFY COLUMN `priority`
                ENUM(
                    'Low',
                    'Medium',
                    'High'
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
        Schema::table('work_orders', function () {
            if (! App::environment('testing')) {
                DB::statement("ALTER TABLE work_orders MODIFY COLUMN `priority`
                ENUM(
                    'Low',
                    'Medium',
                    'High'
                )
            ");
            }
        });
    }
};
