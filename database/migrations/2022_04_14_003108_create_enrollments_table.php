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
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->integer('year');
            
            $table->timestamps();
        });

        Schema::create('sections', function (Blueprint $table) {
            /**
             * Check this field
             */
            $table->id('code');
            $table->integer('quota');
            $table->string('schedule', 255);

            $table->unsignedBigInteger('teacher_id')->index();
            $table->foreign('teacher_id')->references('id')->on('teachers');

            /**
             * Fields with missing Primary Key
             */
            $table->unsignedBigInteger('curriculum_subject_id')->index();
            $table->foreign('curriculum_subject_id')->references('id')->on('curriculum_subjects');

            $table->unsignedBigInteger('period_id')->index();
            $table->foreign('period_id')->references('id')->on('periods');

            $table->primary(['curriculum_subject_id', 'period_id', 'code']);
            
            $table->timestamps();
        });

        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->date('date');
            $table->float('percentage');

            $table->unsignedBigInteger('section_id')->index();
            $table->foreign('section_id')->references('code')->on('sections');
            
            $table->timestamps();
        });

        Schema::create('score_evaluations', function (Blueprint $table) {
            $table->float('score');

            /**
             * Fields with missing Primary Key
             */
            $table->unsignedBigInteger('student_id')->index();
            $table->foreign('student_id')->references('id')->on('students');

            $table->unsignedBigInteger('evaluation_id')->index();
            $table->foreign('evaluation_id')->references('id')->on('evaluations');
            
            $table->timestamps();
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->float('final_score');
            $table->boolean('is_approved');
            $table->integer('enrollment');

            /**
             * Fields with missing Primary Key
             */
            $table->unsignedBigInteger('curriculum_subject_id')->index();
            $table->foreign('curriculum_subject_id')->references('id')->on('curriculum_subjects');

            $table->unsignedBigInteger('period_id')->index();
            $table->foreign('period_id')->references('id')->on('periods');
            
            $table->unsignedBigInteger('code')->index();
            $table->foreign('code')->references('code')->on('sections');

            $table->unsignedBigInteger('student_id')->index();
            $table->foreign('student_id')->references('id')->on('students');

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
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('periods');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('score_evaluations');
    }
};
