<?php

use App\TeacherType;
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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('class_id');
            $table->date('hire_date')->nullable(); // ngày vào làm 
            $table->string('base_salary'); // Lương cơ bản
            $table->softDeletes('deleted_at', 0); // Xử lý xóa mềm
            $table->enum('teacher_type', TeacherType::values())->default(TeacherType::FULLTIME); // Trạng thái làm việc : Full-time , Part-time.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn(['hire_date', 'base_salary', 'deleted_at', 'teacher_type']);
        });
    }
};
