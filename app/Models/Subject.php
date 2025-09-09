<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'name',
        'fee',
        'number_of_lessions',
    ];

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subject_teacher', 'subject_id', 'teacher_id');
    }

    public function classes()
    {
        return $this->hasMany(Classroom::class, 'subject_id', 'id');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'students_subjects', 'subject_id', 'student_id');
    }
}
