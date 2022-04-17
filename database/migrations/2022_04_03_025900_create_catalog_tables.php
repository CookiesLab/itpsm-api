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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::create('departments', function (Blueprint $table) {
          $table->id();
          $table->string('name', 255);

          $table->unsignedBigInteger('country_id')->index();
          $table->foreign('country_id')->references('id')->on('countries');

          $table->timestamps();
        });

        Schema::create('municipalities', function (Blueprint $table) {
          $table->id();
          $table->string('name', 255);

          $table->unsignedBigInteger('department_id')->index();
          $table->foreign('department_id')->references('id')->on('departments');

          $table->unsignedBigInteger('country_id')->index();
          $table->foreign('country_id')->references('id')->on('countries');

          $table->timestamps();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->char('type', 1);

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
        Schema::dropIfExists('countries');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('municipalities');
        Schema::dropIfExists('statuses');
    }
};
