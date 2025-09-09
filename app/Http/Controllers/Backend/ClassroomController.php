<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\ClassroomRepositoryEloquent;
use App\Repositories\SubjectRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Services\ClassroomService;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    protected $classRepo, $classService, $userRepo, $subjectRepo;
    public function __construct(
        ClassroomRepositoryEloquent $classRepo,
        ClassroomService $classService,
        UserRepositoryEloquent $userRepo,
        SubjectRepositoryEloquent $subjectRepo
    ) {
        $this->classRepo = $classRepo;
        $this->classService = $classService;
        $this->userRepo = $userRepo;
        $this->subjectRepo = $subjectRepo;
    }

    public function index(Request $request)
    {
        $template = "backend.classroom.index";
        $config = $this->config();
        $params = $request->only(['page', 'limit']);
        $classes = $this->classService->paginate($params);
        return view('layouts.admin', compact('template', 'config', 'classes'));
    }


    public function create()
    {
        $template = 'backend.classroom.create';
        $config =  $this->config();
        $teachers = $this->userRepo->all();
        $subjects = $this->subjectRepo->all();
        return view('layouts.admin', compact('template', 'config', 'teachers', 'subjects'));
    }
    public function store(Request $request)
    {
        $classroom = $request->validate([
            'name' => ['required'],
            'teacher_id' => ['required'],
            'subject_id' => ['required'],
        ]);

        if ($this->classService->create($classroom)) {
            flash()->success('Thêm môn học mới thành công.');
            return redirect()->route('dashboard');
        }
        flash()->error('Thêm môn mới không thành công. Hãy thử lại.');
        return redirect()->route('dashboard');
    }

    public function edit($id)
    {
        $classroom = $this->classRepo->find($id);
        $teachers = $this->userRepo->all();
        $subjects = $this->subjectRepo->all();
        $template = 'backend.classroom.edit';
        $config =  $this->config();
        return view('layouts.admin', compact('template', 'config', 'subjects', 'teachers', 'classroom'));
    }

    public function update($id, Request $request)
    {
        $classroom = $request->validate([
            'name' => ['required'],
            'teacher_id' => ['required'],
            'subject_id' => ['required'],
        ]);
        if ($this->classService->update($id, $classroom)) {

            flash()->success('Cập nhật môn học thành công');
            return redirect()->route('classroom.index');
        }
        flash()->error('Cập nhật môn học không thành công. Hãy thử lại.');
        return redirect()->route('classroom.index');
    }

    public function delete($id)
    {
        $classroom = $this->classRepo->find($id);
        $template = 'backend.classroom.delete';
        $config =  $this->config();
        return view('layouts.admin', compact('template', 'config', 'classroom'));
    }

    // Cần xử lý logic xóa mềm để khôi phục tất cả các liên kết khi cần
    public function destroy($id)
    {
        if ($this->classService->delete($id)) {
            flash()->success('Xóa lớp học thành công');
            return redirect()->route('classroom.index');
        }
        flash()->error('Xóa thành viên không thành công. Hãy thử lại.');
        return redirect()->route('classroom.index');
    }

    private function config()
    {
        return [
            'breadcrumb' => [
                'index' => config('breadcrumb.class.index'),
                'create' => config('breadcrumb.class.create'),
                'edit' => config('breadcrumb.class.edit'),
                'delete' => config('breadcrumb.class.delete'),
            ],
            'tableHeading' => [
                'index' => config('breadcrumb.class.index')
            ]
        ];
    }
}
