<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false);
            $table->string('code', 6);
            $table->timestamp('code_changed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('customers', function (Blueprint $table)
        {
            $table->dropColumn('is_verified');
            $table->dropColumn('code');
            $table->dropColumn('code_changed_at');
        });
    }
}
