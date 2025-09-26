<?php

namespace App\Http\Controllers\Backend;

use App\Enum\StatusClassroom;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Services\CourseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    protected $courseRepo, $courseService, $userRepo;
    public function __construct(CourseRepositoryEloquent $courseRepo, CourseService $courseService, UserRepositoryEloquent $userRepo)
    {
        $this->courseRepo = $courseRepo;
        $this->courseService = $courseService;
        $this->userRepo = $userRepo;
    }
    public function index(Request $request)
    {
        $template = "backend.course.index";
        $config = $this->config();
        $params = $request->only(['page', 'limit']);
        $courses = $this->courseService->paginate($params);

        return view('layouts.admin', compact('template', 'config', 'courses'));
    }

    public function create()
    {
        $template = 'backend.course.create';
        $config = $this->config();
        $teachers = $this->userRepo->all(['id', 'fullname']);
        $status = StatusClassroom::labels();

        return view('layouts.admin', compact('template', 'config', 'teachers', 'status'));
    }

    public function store(Request $request)
    {
        try {
            $course = $request->validate([
                'name' => ['required'],
                'teacher_id' => ['required'],
                'fee' => ['required'],
                'number_of_lessions' => ['nullable'],
                'status' => ['required', Rule::notIn('0')],
            ]);
            if ($this->courseService->create($course)) {
                flash()->success('Thêm môn học mới thành công.');
                return redirect()->route('course.index');
            }
        } catch (Exception $e) {
            flash()->error($e->getMessage());
        }
    }

    public function edit($id)
    {
        $course = $this->courseRepo->find($id);
        $teachers = $this->userRepo->all();
        $status = StatusClassroom::labels();
        $template = 'backend.course.edit';
        $config = $this->config();
        return view('layouts.admin', compact('template', 'config', 'status', 'course', 'teachers'));
    }



    public function update($id, Request $request)
    {
        $course = $request->validate([
            'name' => ['required'],
            'teacher_id' => ['required'],
            'fee' => ['required'],
            'number_of_lessions' => ['nullable'],
            'status' => ['required'],
        ]);

        if ($this->courseService->update($id, $course)) {

            flash()->success('Cập nhật môn học thành công');
            return redirect()->route('course.index');
        }
        flash()->error('Cập nhật môn học không thành công. Hãy thử lại.');
        return redirect()->route('course.index');
    }

    public function delete($id)
    {
        $course = $this->courseRepo->find($id);
        $template = 'backend.course.delete';
        $config = $this->config();
        return view('layouts.admin', compact('template', 'config', 'course'));
    }

    public function destroy($id)
    {

        try {
            $this->courseService->delete($id);
            flash()->success('Xóa khóa học thành công');
        } catch (Exception $e) {
            $message = $e->getMessage();
            flash()->warning($message);
            return to_route('course.index');
        }

        return to_route('course.index');
    }

    public function filter(Request $request)
    {
        $template = 'backend.course.index';
        $filter = $request->all();
        $config = $this->config();
        $courses = $this->courseRepo->filter($filter);

        if ($courses) {
            return view('layouts.admin', compact('template', 'config', 'courses'));
        }

        if ($courses->total() === 0) {
            return view('layouts.admin', compact('template', 'config'));
        }

        return abort(404, 'Không tìm thấy thông tin học viên');
    }
    private function config()
    {
        return [
            'breadcrumb' => [
                'index' => config('breadcrumb.course.index'),
                'create' => config('breadcrumb.course.create'),
                'edit' => config('breadcrumb.course.edit'),
                'delete' => config('breadcrumb.course.delete'),
            ],
            'tableHeading' => [
                'index' => config('breadcrumb.course.index')
            ]
        ];
    }
}
