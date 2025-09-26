<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistoric extends Model
{
    protected $table = 'payment_histories';

    protected $fillable = [
        'class_id',
        'course_id',
        'student_id',
        'paid_amount',
        'remaining',
        'fee_status',
        'payment_method',
        'payment_date',
    ];


    public $timestamps = FALSE;

}
