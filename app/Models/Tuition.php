<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
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

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }



}
