<?php

namespace App\Models;

use App\Enum\StatusClassroom;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCourse
 */
class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'fee',
        'number_of_lessions',
        'status'
    ];
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'course_teacher', 'course_id', 'teacher_id');
    }

    public function classes()
    {
        return $this->hasMany(Classroom::class, 'course_id', 'id');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id');
    }
}
