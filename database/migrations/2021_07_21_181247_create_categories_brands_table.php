<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_brands', function (Blueprint $table) {
            $table->bigInteger('categories_id')->unsigned();
            $table->bigInteger('brands_id')->unsigned();
            $table->timestamps();
            $table->primary(['categories_id', 'brands_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_brands');
    }
}
