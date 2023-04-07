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
      Schema::create('equivalence', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('AcademicHistory_id')->nullable();
        $table->foreign('AcademicHistory_id')->references('id')->on('academic_history');
        $table->unsignedBigInteger('subject_id')->nullable();
        $table->string("subjectName");
        $table->string("institution");
        $table->boolean('IsinnerEquivalence')->default(0);
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
        Schema::dropIfExists('equivalence');
    }
};
