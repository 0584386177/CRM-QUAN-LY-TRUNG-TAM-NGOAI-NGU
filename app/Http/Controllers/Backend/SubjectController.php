<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\SubjectRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectRepo, $subjectService, $userRepo;
    public function __construct(SubjectRepositoryEloquent $subjectRepo, SubjectService $subjectService, UserRepositoryEloquent $userRepo)
    {
        $this->subjectRepo = $subjectRepo;
        $this->subjectService = $subjectService;
        $this->userRepo = $userRepo;
    }
    public function index(Request $request)
    {
        $template = "backend.subject.index";
        $config = $this->config();
        $params = $request->only(['page', 'limit']);
        $subjects = $this->subjectService->paginate($params);
 
        return view('layouts.admin', compact('template', 'config', 'subjects'));
    }

    public function create()
    {
        $template = 'backend.subject.create';
        $config =  $this->config();
        $teachers = $this->userRepo->all(['id', 'fullname']);

        return view('layouts.admin', compact('template', 'config', 'teachers'));
    }

    public function store(Request $request)
    {
        $subject = $request->validate([
            'name' => ['required'],
            'teacher_id' => ['required']
        ]);

        if ($this->subjectService->create($subject)) {
            flash()->success('Thêm môn học mới thành công.');
            return redirect()->route('dashboard');
        }
        flash()->error('Thêm môn mới không thành công. Hãy thử lại.');
        return redirect()->route('dashboard');
    }

    public function edit($id)
    {
        $subject = $this->subjectRepo->find($id);
        $teachers = $this->userRepo->all();
        $template = 'backend.subject.edit';
        $config =  $this->config();
        return view('layouts.admin', compact('template', 'config', 'subject', 'teachers'));
    }

    public function update($id, Request $request)
    {
        $subject = $request->validate([
            'name' => ['required'],
            'teacher_id' => ['required'],
            'fee' => ['required'],
            'number_of_lessions' => ['nullable'],
        ]);

        if ($this->subjectService->update($id, $subject)) {

            flash()->success('Cập nhật môn học thành công');
            return redirect()->route('subject.index');
        }
        flash()->error('Cập nhật môn học không thành công. Hãy thử lại.');
        return redirect()->route('subject.index');
    }

    public function delete($id)
    {
        $subject = $this->subjectRepo->find($id);
        $template = 'backend.subject.delete';
        $config =  $this->config();
        return view('layouts.admin', compact('template', 'config', 'subject'));
    }

    public function destroy($id)
    {

        if ($this->subjectService->delete($id)) {
            flash()->success('Xóa thành viên thành công');
            return redirect()->route('subject.index');
        }
        flash()->error('Xóa thành viên không thành công. Hãy thử lại.');
        return redirect()->route('subject.index');
    }

    // public function filter(Request $request)
    // {

    //     $template = 'backend.student.index';
    //     $filter = $request->all();
    //     $config = $this->config();
    //     $students = $this->subjectRepo->filter($filter);

    //     if ($students) {
    //         return view('layouts.admin', compact('template', 'config', 'students'));
    //     }

    //     if ($students->total() === 0) {
    //         return view('layouts.admin', compact('template', 'config'));
    //     }

    //     return abort(404, 'Không tìm thấy thông tin học viên');
    // }
    private function config()
    {
        return [
            'breadcrumb' => [
                'index' => config('breadcrumb.subject.index'),
                'create' => config('breadcrumb.subject.create'),
                'edit' => config('breadcrumb.subject.edit'),
                'delete' => config('breadcrumb.subject.delete'),
            ],
            'tableHeading' => [
                'index' => config('breadcrumb.subject.index')
            ]
        ];
    }
}
