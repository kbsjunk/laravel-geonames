<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_codes', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('feature_class', 1)->index();
            $table->string('feature_code', 10)->index();
            $table->string('name');
            $table->string('description');
            $table->string('language', 7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feature_codes');
    }
}
