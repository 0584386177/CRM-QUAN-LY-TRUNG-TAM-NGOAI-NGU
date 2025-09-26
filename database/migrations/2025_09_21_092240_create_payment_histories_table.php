<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('w', function (Blueprint $table) {
            $table->id();
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('student_id')->references('id')->on('students');
            $table->bigInteger('paid_amount')->default(0);
            $table->bigInteger('remaining')->default(0);
            $table->string('fee_status')->default('unpaid');
            $table->string('payment_method')->default('transfer');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
