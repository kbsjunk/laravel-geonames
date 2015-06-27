<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmin2CodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin2_codes', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('name');
            $table->string('name_ascii')->nullable();
            $table->string('iso_code')->nullable()->index();
            $table->string('fips_code')->nullable()->index();
            $table->string('admin1_code');
            $table->string('country_code', 2);
            $table->integer('geoname_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin2_codes');
    }
}
