<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ac_student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->foreignId('period_id');
            $table->foreignId('classroom_id');
            $table->foreignId('admission_id');
            $table->foreignId('student_id');
            $table->foreignId('next_grade_id')->nullable();
            $table->string('status'); // registered promoted, repeat, graduated;
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
        Schema::dropIfExists('ic_admissions');
    }
};
