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
        Schema::create('academic_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('student_id')->on('student_curricula')->nullable();
            $table->unsignedBigInteger('curriculum_id');
            $table->foreign('curriculum_id')->references('curriculum_id')->on('student_curricula')->nullable();
            $table->float('totalScore');
            $table->boolean('IsEquivalence')->default(0);
            $table->integer('year');
            $table->integer('period');
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
        Schema::dropIfExists('academic_history');
    }
};
