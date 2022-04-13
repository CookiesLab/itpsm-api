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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('last_name', 255);
            $table->date('birth_date');
            $table->string('nit', 14);
            $table->string('dui', 9);
            $table->string('isss_number', 20)->nullable();
            $table->string('nup_number', 30)->nullable();
            $table->string('email', 255);
            $table->char('genre', 1);
            $table->text('address')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('home_phone_number', 15)->nullable();

            $table->unsignedBigInteger('municipality_id')->index();
            $table->foreign('municipality_id')->references('id')->on('municipalities');

            $table->unsignedBigInteger('department_id')->index();
            $table->foreign('department_id')->references('id')->on('departments');

            $table->unsignedBigInteger('country_id')->index();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->unsignedBigInteger('status_id')->index();
            $table->foreign('status_id')->references('id')->on('status');

            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            
            $table->timestamps();
        });

        Schema::create('teacher_languages', function (Blueprint $table) {
            $table->id();
            $table->char('level', 2);

            $table->unsignedBigInteger('teacher_id')->index();
            $table->foreign('teacher_id')->references('id')->on('teachers');

            $table->unsignedBigInteger('language_id')->index();
            $table->foreign('language_id')->references('id')->on('languages');
            
            $table->timestamps();
        });

        Schema::create('teacher_degrees', function (Blueprint $table) {
            $table->id();
            $table->string('degree', 255);
            $table->date('date');
            $table->string('institution', 255);

            $table->unsignedBigInteger('teacher_id')->index();
            $table->foreign('teacher_id')->references('id')->on('teachers');
            
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
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('teacher_languages');
        Schema::dropIfExists('teacher_degrees');
    }
};
