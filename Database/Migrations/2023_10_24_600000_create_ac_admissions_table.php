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
        Schema::create('ac_admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->foreignId('period_id');
            $table->foreignId('classroom_id');
            $table->foreignId('classroom_period_id');
            $table->foreignId('student_id');
            $table->foreignId('client_id');
            $table->foreignId('tutor_id');
            $table->string('status'); // draft, in progress, completed, archived

            // enrolled data
            $table->date('date');
            $table->date('end_date')->nullable();
            $table->date('first_invoice_date');
            $table->date('next_invoice_date')->nullable();

            // accounting data
            $table->foreignId('account_id')->nullable();
            $table->foreignId('client_account_id')->nullable();
            $table->foreignId('late_fee_account_id')->nullable();

            // invoicing data
            $table->decimal('amount', 14, 4)->default(0.00);
            $table->decimal('amount_paid', 14, 4)->default(0.00);
            $table->decimal('amount_due', 14, 4)->default(0.00);
            $table->decimal('total', 14, 4)->default(0.00);

            // Penalty config
            $table->decimal('commission', 14, 4)->default(0.00);
            $table->enum('commission_type', ['PERCENTAGE', 'FIXED'])->default('PERCENTAGE');

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
