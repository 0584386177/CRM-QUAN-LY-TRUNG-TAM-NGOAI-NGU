<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\PaymentHistory;
use App\Models\Student;
use App\Models\Tuition;
use App\Services\PaymentHistoryService;
use App\Services\TuitionService;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    protected $paymentHistoryService;
    public function __construct(PaymentHistoryService $paymentHistoryService)
    {
        $this->paymentHistoryService = $paymentHistoryService;
    }
    public function index(Request $request)
    {
        $template = 'backend.tuition.index';
        $config = $this->config();

        $students = Student::with(['courses', 'teachers', 'payments'])
            ->search($request->input('search'))
            ->paginate(10);



        $data = $students->map(function ($item) {
            return [
                'id' => $item->id,
                'fullname' => $item->fullname,
                'course' => $item->courses
                    ->pluck('name')
                    ->implode(','),
                'fee' => $item->courses
                    ->pluck('fee')
                    ->implode(','),
                'total_paid' => $item->getTotalPaid(),
                'remaining' => $item->getLastestRemaining(),
                'fee_status' => $item->getPaidStatus(),
            ];

        })
        ;

        return view('layouts.admin', compact('template', 'config', 'data'));
    }


    private function config()
    {
        return [
            'breadcrumb' => [
                'index' => config('breadcrumb.tuition.index'),
                'create' => config('breadcrumb.tuition.create'),
                'edit' => config('breadcrumb.tuition.edit'),
                'delete' => config('breadcrumb.tuition.delete'),
            ],
            'tableHeading' => [
                'index' => config('breadcrumb.tuition.index')
            ]
        ];
    }
}
