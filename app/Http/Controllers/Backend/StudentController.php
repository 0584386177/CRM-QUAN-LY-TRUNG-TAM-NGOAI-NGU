<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Repositories\ClassroomRepositoryEloquent;
use App\Repositories\StudentRepositoryEloquent;
use App\Repositories\SubjectRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $studentRepo, $studentService, $classroomService, $userRepo, $subjectRepo;
    public function __construct(
        UserRepositoryEloquent $userRepo,
        StudentRepositoryEloquent $studentRepo,
        StudentService $studentService,
        ClassroomRepositoryEloquent $classroomService,
        SubjectRepositoryEloquent $subjectRepo
    ) {
        $this->userRepo = $userRepo;
        $this->studentRepo = $studentRepo;
        $this->studentService = $studentService;
        $this->classroomService = $classroomService;
        $this->subjectRepo = $subjectRepo;
    }
    public function index(Request $request)
    {
        $template = "backend.student.index";
        $config = $this->config();
        $params = $request->only(['page', 'limit']);
        $students = $this->studentService->paginate($params);
        return view('layouts.admin', compact('template', 'config', 'students'));
    }

    public function create()
    {
        $template = 'backend.student.create';
        $classes = $this->classroomService->all();
        $teachers = $this->userRepo->all();
        $subjects = $this->subjectRepo->all();
        $config =  $this->config();
        return view('layouts.admin', compact('template', 'config', 'classes', 'teachers', 'subjects'));
    }

    public function store(StoreStudentRequest $request)
    {
        $student = $request->except(['_token']);
        if ($this->studentService->create($student)) {
            flash()->success('Thêm học viên thành công.');
            return redirect()->route('dashboard');
        }
        flash()->error('Đăng ký thành viên không thành công. Hãy thử lại.');
        return redirect()->route('dashboard');
    }

    public function edit($id)
    {
        $student = $this->studentRepo->find($id);
        $subjects = $this->subjectRepo->all();
        $template = 'backend.student.edit';
        $config =  $this->config();
        return view('layouts.admin', compact('template', 'config', 'student', 'subjects'));
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
        $config =  $this->config();
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

    public function filter(Request $request)
    {

        $template = 'backend.student.index';
        $filter = $request->all();
        $config = $this->config();
        $students = $this->studentRepo->filter($filter);

        if ($students) {
            return view('layouts.admin', compact('template', 'config', 'students'));
        }

        if ($students->total() === 0) {
            return view('layouts.admin', compact('template', 'config'));
        }

        return abort(404, 'Không tìm thấy thông tin học viên');
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
