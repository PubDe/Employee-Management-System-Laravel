<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('month');
            $table->integer('year');

            $table->decimal('gross_salary', 12, 2);
            $table->decimal('total_deductions', 12, 2);
            $table->decimal('net_salary', 12, 2);

            $table->string('status')->default('pending');
            $table->date('payment_date')->nullable();

            $table->timestamps();

            $table->unique(['employee_id','month','year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
