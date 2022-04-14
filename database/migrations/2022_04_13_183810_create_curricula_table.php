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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 5);
            
            $table->timestamps();
        });

        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('scholarship_foundation', 255);
            
            $table->timestamps();
        });

        Schema::create('prerequisites', function (Blueprint $table) {
            $table->id();

            /**
             * Fields with missing Primary Key
             */
            $table->unsignedBigInteger('curriculum_subject_id')->index();
            $table->foreign('curriculum_subject_id')->references('id')->on('curriculum_subjects');
            
            $table->timestamps();
        });

        Schema::create('curricula', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('year');
            $table->boolean('is_active');

            $table->unsignedBigInteger('career_id')->index();
            $table->foreign('career_id')->references('id')->on('careers');

            $table->timestamps();
        });

        Schema::create('student_curricula', function (Blueprint $table) {
            $table->float('cum');
            $table->integer('entry_year');
            $table->date('graduation_year')->nullable();
            $table->float('scholarship_rate')->nullable();

            /**
             * Fields with missing Primary Key
             */
            $table->unsignedBigInteger('student_id')->index();
            $table->foreign('student_id')->references('id')->on('students');

            $table->unsignedBigInteger('curriculum_id')->index();
            $table->foreign('curriculum_id')->references('id')->on('curricula');

            /**
             * Make nullable
             */
            $table->unsignedBigInteger('scholarship_id')->index();
            $table->foreign('scholarship_id')->references('id')->on('scholarships')->nullable();
            
            $table->timestamps();
        });

        Schema::create('curriculum_subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('uv');

            $table->unsignedBigInteger('curriculum_id')->index();
            $table->foreign('curriculum_id')->references('id')->on('curricula');

            $table->unsignedBigInteger('subject_id')->index();
            $table->foreign('subject_id')->references('id')->on('subjects');
            
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
        Schema::dropIfExists('curricula');
        Schema::dropIfExists('careers');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('scholarships');
        Schema::dropIfExists('prerequisites');
        Schema::dropIfExists('curriculum_subjects');
    }
};
