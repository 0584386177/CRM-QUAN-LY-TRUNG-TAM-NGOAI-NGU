<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperClassroom
 */
class Classroom extends Model
{

    protected $table = 'classes';
    protected $fillable = [
        'name',
        'course_id',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_students', 'class_id', 'student_id');
    }


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'class_teacher', 'class_id', 'teacher_id');
    }

    // public function payments()
    // {
    //     return $this->hasMany(PaymentHistoric::class, 'class_id', 'id');
    // }
}
