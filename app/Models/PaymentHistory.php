<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

class PaymentHistory extends Model
{
    protected $table = 'payment_histories';

    protected $fillable = [
        'class_id',
        'student_id',
        'course_id',
        'paid_amount',
        'remaining',
        'fee_status',
        'payment_method',
        'payment_date'
    ];

    public $timestamps = FALSE;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    // Lọc tìm kính theo các trường của danh sách (họ và tên , khóa học)

    public function scopeSearch(Builder $query, $needle)
    {
        return $query->when($needle, function (Builder $q) use ($needle) {
            $q->whereHas('student', function ($q1) use ($needle) {
                $q1->where('fullname', 'LIKE', '' . $needle . '');
            })
                ->orWhereHas('course', function (Builder $q2) use ($needle) {
                    $q2->where('name', 'LIKE', '' . $needle . '');
                })
            ;
        });
    }




}
