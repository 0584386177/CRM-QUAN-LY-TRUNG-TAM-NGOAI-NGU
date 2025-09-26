<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; //

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;


    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'address',
        'birthday',
        'avatar',
        'hire_date',
        'base_salary',
        'teacher_type',
        'bio',
        'status',
        'password',
        'activation_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
            'hire_date' => 'date',
        ];
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_teachers', 'teacher_id', 'student_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Classroom::class, 'class_teacher', 'teacher_id', 'class_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher', 'teacher_id', 'course_id');
    }

  
}
