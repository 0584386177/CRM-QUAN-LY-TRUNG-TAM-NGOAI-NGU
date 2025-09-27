<?php

namespace App\Http\Controllers\Backend;

use App\Enum\PaymentMethod;
use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Repositories\ClassroomRepositoryEloquent;
use App\Repositories\CourseRepositoryEloquent;
use App\Repositories\StudentRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Services\StudentService;
use App\Traits\Filterable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    protected $studentRepo, $studentService, $classroomService, $classRepo, $userRepo, $courseRepo;
    public function __construct(
        UserRepositoryEloquent $userRepo,
        StudentRepositoryEloquent $studentRepo,
        StudentService $studentService,
        ClassroomRepositoryEloquent $classroomService,
        CourseRepositoryEloquent $courseRepo,
        ClassroomRepositoryEloquent $classRepo,
    ) {
        $this->userRepo = $userRepo;
        $this->studentRepo = $studentRepo;
        $this->studentService = $studentService;
        $this->classroomService = $classroomService;
        $this->classRepo = $classRepo;
        $this->courseRepo = $courseRepo;
    }
    public function index(Request $request)
    {
        $template = "backend.student.index";
        $config = $this->config();
        $students = Student::query()
            ->search($request->input('search'))
            ->statusTuition($request->input('fee_status'))
            ->paginate(10);
        return view('layouts.admin', compact('template', 'config', 'students'));
    }

    public function create()
    {
        $template = 'backend.student.create';
        $classes = $this->classroomService->all();
        $teachers = $this->userRepo->all();
        $courses = $this->courseRepo->all();
        $config = $this->config();
        return view('layouts.admin', compact('template', 'config', 'classes', 'teachers', 'courses'));
    }

    public function store(StoreStudentRequest $request)
    {
        $student = $request->except(['_token', 'is_active']);
        if ($this->studentService->create($student)) {
            flash()->success('Thêm học viên thành công.');
            return redirect()->route('student.index');
        }
        flash()->error('Đăng ký thành viên không thành công. Hãy thử lại.');
        return redirect()->route('student.index');
    }

    public function edit($id)
    {
        $student = $this->studentRepo->find($id);

        $courses = $this->courseRepo->all();
        $classes = $this->classRepo->all();
        $teachers = $this->userRepo->all();
        $template = 'backend.student.edit';
        $config = $this->config();
        return view('layouts.admin', compact('template', 'config', 'student', 'courses', 'classes', 'teachers'));
    }

    public function update($id, UpdateStudentRequest $request)
    {
        if ($this->studentService->update($id, $request)) {

            flash()->success('Cập nhật thành viên thành công');
            return redirect()->route('student.index');
        }
        flash()->error('Cập nhật thành viên không thành công. Hãy thử lại.');
        return redirect()->route('student.index');
    }

    public function delete($id)
    {
        $student = $this->studentRepo->find($id);
        $template = 'backend.student.delete';
        $config = $this->config();
        return view('layouts.admin', compact('template', 'config', 'student'));
    }

    public function destroy($id)
    {
        if ($this->studentRepo->delete($id)) {
            flash()->success('Xóa thành viên thành công');
            return redirect()->route('student.index');
        }
        flash()->error('Xóa thành viên không thành công. Hãy thử lại.');
        return redirect()->route('student.index');
    }



    // public function filter(Request $request)
    // {

    //     $filters = $request->only(['search', 'fee_status']);
    //     $students = Student::query()
    //         ->search($filters['search'])
    //         ->statusTuition($filters['fee_status'])
    //         ->paginate(10)
    //     ;

    //     return $students;
    // }

    public function exportXLSX()
    {
        return Excel::download(
            new StudentExport,
            'student_' . date('d-m-Y') . '.xlsx',
            \Maatwebsite\Excel\Excel::XLSX,
            [
                'Content-Type' => 'text/xlsx; charset=utf-8;',
            ]
        );
    }

    private function config()
    {
        return [
            'breadcrumb' => [
                'index' => config('breadcrumb.student.index'),
                'create' => config('breadcrumb.student.create'),
                'edit' => config('breadcrumb.student.edit'),
                'delete' => config('breadcrumb.student.delete'),
            ],
            'tableHeading' => [
                'index' => config('breadcrumb.student.index')
            ]
        ];
    }
}
