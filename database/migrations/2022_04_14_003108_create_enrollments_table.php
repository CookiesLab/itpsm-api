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
            $table->char('status', 1);

            $table->timestamps();
            $table->softDeletes();
        });



  /*      Schema::create('schedules', function (Blueprint $table) {
					$table->id();
          $table->integer('day_of_week');
          $table->string('start_hour');
          $table->string('end_hour');

					//$table->unsignedBigInteger('code')->index();
          //$table->foreign('code')->references('code')->on('sections');

          //$table->unsignedBigInteger('curriculum_subject_id')->index();
          //$table->foreign('curriculum_subject_id')->references('id')->on('curriculum_subjects');

          //$table->unsignedBigInteger('period_id')->index();
          //$table->foreign('period_id')->references('id')->on('periods');

          $table->timestamps();
          $table->softDeletes();
      });*/
      Schema::create('sections', function (Blueprint $table) {
        $table->id();
        $table->integer('quota');
        //$table->string('schedule', 255);
        $table->integer('start_week');
        $table->integer('end_week');
        $table->unsignedBigInteger('teacher_id')->nullable();
        $table->foreign('teacher_id')->references('id')->on('teachers')->nullable();

        /**
         * Fields with missing Primary Key
         */
        $table->unsignedBigInteger('code')->index();

        $table->unsignedBigInteger('curriculum_subject_id')->index();
        $table->foreign('curriculum_subject_id')->references('id')->on('curriculum_subjects');

        $table->unsignedBigInteger('period_id')->index();
        $table->foreign('period_id')->references('id')->on('periods');

        //$table->primary(['curriculum_subject_id', 'period_id', 'code'], 'section_primary');
       /* $table->unsignedBigInteger('id_schedule')->index();
        $table->foreign('id_schedule')->references('id')->on('schedules');*/
        //$table->foreign('code')->references('id')->on('schedules');
        $table->timestamps();
        $table->softDeletes();
      });
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->date('date');
            $table->float('percentage');
            $table->integer('is_public')->default(0);
            $table->integer('is_approved')->default(0);
            $table->integer('level')->default(1);
            $table->unsignedBigInteger('principal_id')->nullable();
            $table->foreign('principal_id')->references('id')->on('evaluations');
            $table->unsignedBigInteger('section_id')->index();
            $table->foreign('section_id')->references('id')->on('sections');

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

            $table->primary(['student_id', 'evaluation_id']);

            $table->timestamps();
        });

        Schema::create('enrollments', function (Blueprint $table) {
         
            $table->float('final_score')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->integer('enrollment')->default(1);

            /**
             * Fields with missing Primary Key
             */
            $table->unsignedBigInteger('curriculum_subject_id')->index();
            $table->foreign('curriculum_subject_id')->references('id')->on('curriculum_subjects');

           /* $table->unsignedBigInteger('period_id')->index();
            $table->foreign('period_id')->references('id')->on('periods');*/

            $table->unsignedBigInteger('code')->index();
            $table->foreign('code')->references('id')->on('sections');

            $table->unsignedBigInteger('student_id')->index();
            $table->foreign('student_id')->references('id')->on('students');

          /*  $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->nullable();
          $table->unsignedBigInteger('id_schedule')->index();
          $table->foreign('id_schedule')->references('id')->on('schedules');
            $table->primary(['student_id', 'curriculum_subject_id', 'period_id', 'code'], 'enrollment_primary');*/

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
