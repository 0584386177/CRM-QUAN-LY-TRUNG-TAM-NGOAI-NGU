<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\StudentRepositoryEloquent;
use App\Services\StudentService;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    protected $studentRepo;
    protected $studentService;
    public function __construct(StudentRepositoryEloquent $studentRepo, StudentService $studentService)
    {
        $this->studentRepo = $studentRepo;
        $this->studentService = $studentService;
    }

    public function updateTuitionStudent($id, Request $request)
    {
        $payload = $request->validate([
            'tuition' => 'required|numeric|min:0',
            'payment_method' => 'required',
        ]);


        if ($this->studentService->updateTuition($id, $payload)) {
            flash()->success('Cập nhật học phí thành công');
            return back();
        }
        flash()->error('Cập nhật học phí không thành công. Hãy thử lại.');
        return back();

    }
}
