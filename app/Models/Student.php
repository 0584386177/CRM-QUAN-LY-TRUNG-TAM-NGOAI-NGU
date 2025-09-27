<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'student_teachers', 'student_id', 'teacher_id');
    }

    public function payments()
    {
        return $this->hasMany(PaymentHistoric::class, 'student_id', 'id');
    }

    // Lọc dữ liệu tìm kiếm
    public function scopeSearch(Builder $query, $search)
    {

        return $query->when(!empty($search), function ($q) use ($search) {
            // Lọc họ và tên
            $q->where('fullname', 'LIKE', '%' . $search . '%')
                // Lọc email
                ->orWhere('email', 'LIKE', '%' . $search . '%')

                // Lọc sdt
                ->orWhere('phone', 'LIKE', '%' . $search . '%')
                // Lọc theo lớp của học viên
                ->orWhereHas('classes', function ($q2) use ($search) {
                    $q2->where('name', 'LIKE', '' . $search . '');
                })
                // Lọc theo giáo viên của học viên
                ->orWhereHas('teachers', function ($q3) use ($search) {
                    $q3->where('fullname', 'LIKE', '' . $search . '');
                })
                // Lọc khóa học của học viên
                ->orWhereHas('courses', function ($q4) use ($search) {
                    $q4->where('name', 'LIKE', '' . $search . '');
                });

        });

    }

    public function scopeStatusTuition(Builder $query, $status)
    {
        return $query->when(!is_null($status), function ($q) use ($status) {
            $q->withWhereRelation('payments', 'fee_status', '=', $status);
        });
    }

}
