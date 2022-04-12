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
    Schema::create('students', function (Blueprint $table) {
      $table->id();
      $table->string('carnet', 25)->unique();
      $table->string('name', 255);
      $table->string('last_name', 255);
      $table->string('email', 255);
      $table->date('birth_date');
      $table->text('address')->nullable();
      $table->string('phone_number', 15)->nullable();
      $table->string('home_phone_number', 15)->nullable();
      $table->char('gender', 1);
      $table->char('relationship', 1);
      $table->char('status', 1);
      $table->string('blood_type', 10)->nullable();
      $table->string('mother_name')->nullable();
      $table->string('mother_phone_number', 15)->nullable();
      $table->string('father_name')->nullable();
      $table->string('father_phone_number', 15)->nullable();
      $table->string('emergency_contact_name')->nullable();
      $table->string('emergency_contact_phone', 15)->nullable();
      $table->string('diseases')->nullable();
      $table->string('allergies')->nullable();
      $table->date('entry date')->nullable();
      $table->integer('date_high_school_degree')->nullable();

      /**
       * Fields with missing Primary Key
       */
      $table->unsignedBigInteger('municipality_id')->index();
      $table->foreign('municipality_id')->references('id')->on('municipalities');

      $table->unsignedBigInteger('department_id')->index();
      $table->foreign('department_id')->references('id')->on('departments');

      $table->unsignedBigInteger('country_id')->index();
      $table->foreign('country_id')->references('id')->on('countries');

      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('medial_exam', function (Blueprint $table) {
      $table->id();
      $table->string('name', 255);
      $table->text('description');
    });

    Schema::create('student_medical_exam', function (Blueprint $table) {
      $table->id();
      $table->text('remark')->nullable();
      $table->date('realization_date');
      $table->date('expiration_date');

      /**
       * Fields with missing Primary Key
       */
      $table->unsignedBigInteger('exam_id')->index();
      $table->foreign('exam_id')->references('id')->on('medical_exam');

      $table->unsignedBigInteger('student_id')->index();
      $table->foreign('student_id')->references('id')->on('students');
    });

    Schema::create('disability', function (Blueprint $table) {
      $table->id();
      $table->string('disability', 255);
      $table->string('subdisability', 255)->nullable();
    });

    Schema::create('student_disability', function (Blueprint $table) {
      /**
       * Fields with missing Primary Key
       */
      $table->unsignedBigInteger('disability_id')->index();
      $table->foreign('disability_id')->references('id')->on('disability');

      $table->unsignedBigInteger('student_id')->index();
      $table->foreign('student_id')->references('id')->on('students');
    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('students');
    Schema::dropIfExists('medial_exam');
    Schema::dropIfExists('student_medical_exam');
    Schema::dropIfExists('disability');
    Schema::dropIfExists('student_disability');
  }
};
