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
      Schema::table('student_curricula', function (Blueprint $table) {
        //$table->integer('uv')->nullable();
        $table->integer('uv_total')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('evaluations', function (Blueprint $table) {
       // $table->dropColumn('uv');
        $table->dropColumn('uv_total');
      });
    }
};
