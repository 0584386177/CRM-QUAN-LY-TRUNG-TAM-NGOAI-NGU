<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use App\Services\TuitionService;
use Illuminate\Http\Request;

class TuitionController extends Controller
{
    protected $tuitionService;
    public function __construct(TuitionService $tuitionService)
    {
        $this->tuitionService = $tuitionService;
    }
    public function index()
    {
        $template = 'backend.tuition.index';
        $config = $this->config();


        $list_tuition = Tuition::with('course')->get();

        $data = $list_tuition->map(function ($item) {

            return [
                'name' => $item->course->name,
                'status' => $item->course->status,
                'tuition' => $item->course->fee,
                'lessions' => $item->course->number_of_lessions,
                'student_count' => $item->course->students()->count(),
            ];

        });




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
