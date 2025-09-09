<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Student extends Model
{
    use HasFactory, Notifiable, HasRoles;


    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'address',
        'birthday',
        'bio',
        'avatar',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [];


    protected $casts = [
        'birthday' => 'date',
    ];
    public function classes()
    {
        return $this->belongsToMany(Classroom::class, 'class_students', 'student_id', 'class_id');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'students_subjects', 'student_id', 'subject_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'student_teachers', 'student_id', 'teacher_id');
    }
}
