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
      Schema::create('ac_grade_fees', function (Blueprint $table) {
          $table->id();
          $table->foreignId('team_id');
          $table->foreignId('user_id');
          $table->foreignId('fee_category_id');
          $table->foreignId('level_id');
          $table->json('grade_ids');
          $table->string('name');
          $table->text('description');
          $table->decimal('tuition_fee', 14, 4)->default(0);
          $table->decimal('additional_fees', 14, 4)->default(0);
          $table->decimal('other_fees',  14, 4)->default(0);
          $table->timestamps();
      });

      Schema::create('ac_fee_discounts', function (Blueprint $table) {
          $table->id();
          $table->foreignId('team_id');
          $table->foreignId('user_id');
          $table->foreignId('level_id');
          $table->foreignId('grade_id');
          $table->string('name');
          $table->text('description')->nullable();
          $table->decimal('amount', 14, 4)->default(0);
          $table->timestamps();
      });

      Schema::create('ac_fee_scholarships', function (Blueprint $table) {
          $table->id();
          $table->foreignId('team_id');
          $table->foreignId('user_id');
          $table->foreignId('level_id');
          $table->foreignId('grade_id');
          $table->string('name');
          $table->text('description')->nullable();
          $table->decimal('amount', 14, 4)->default(0);
          $table->timestamps();
      });

      Schema::create('ac_fee_student_discounts', function (Blueprint $table) {
          $table->id();
          $table->foreignId('team_id');
          $table->foreignId('user_id');
          $table->foreignId('discount_id');
          $table->foreignId('student_id');
          $table->timestamps();
      });

      Schema::create('ac_fee_student_scholarships', function (Blueprint $table) {
          $table->id();
          $table->foreignId('team_id');
          $table->foreignId('user_id');
          $table->foreignId('scholarship_id');
          $table->foreignId('student_id');
          $table->timestamps();
      });

      Schema::table('payments', function (Blueprint $table) {
        $table->foreignId('applied_discount_id')->nullable();
        $table->foreignId('applied_scholarship_id')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
