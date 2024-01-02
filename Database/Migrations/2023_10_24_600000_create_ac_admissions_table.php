<?php

use Illuminate\Support\Facades\Schema;
use Modules\Academic\Entities\Admission;
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
        Schema::create('ac_admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->foreignId('period_id');
            $table->foreignId('classroom_id');
            $table->foreignId('level_id')->nullable();
            $table->foreignId('grade_id')->nullable();
            $table->foreignId('student_id');
            $table->foreignId('client_id');
            $table->string('type')->default(Admission::TYPE_ENROLLMENT);
            $table->string('status'); // draft, in progress, completed, archived

            // enrollment data
            $table->string('student_name')->nullable();
            $table->string('names')->nullable();
            $table->string('lastnames')->nullable();
            $table->string('grade_name')->nullable();
            $table->text('parents_names')->nullable();
            $table->date('date');
            $table->date('end_date')->nullable();
            $table->date('first_invoice_date');
            $table->date('next_invoice_date')->nullable();

            // accounting data
            $table->foreignId('account_id')->nullable();
            $table->foreignId('client_account_id')->nullable();
            $table->foreignId('late_fee_account_id')->nullable();

            // invoicing data
            $table->decimal('fee', 14, 4)->default(0.00);
            $table->decimal('amount', 14, 4)->default(0.00);
            $table->decimal('amount_paid', 14, 4)->default(0.00);
            $table->decimal('amount_due', 14, 4)->default(0.00);
            $table->decimal('total', 14, 4)->default(0.00);

            // Penalty config
            $table->decimal('deposit', 14, 4)->default(0.00);
            $table->boolean('require_deposit')->default(true);
            $table->decimal('late_fee', 14, 4)->default(0.00);
            $table->enum('late_fee_type', ['PERCENTAGE', 'PERCENTAGE_OUTSTANDING', 'FIXED'])->default('PERCENTAGE');
            $table->integer('grace_days')->default(0);

            // config
            $table->json('generated_invoice_dates')->default('[]');
            $table->json('additional_fees')->default('[]');

            $table->text('notes')->nullable();
            $table->date('cancelled_at')->nullable();
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
