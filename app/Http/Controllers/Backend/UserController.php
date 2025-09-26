<?php

namespace App\Http\Controllers\Backend;

use App\Enum\TeacherStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\ClassroomRepositoryEloquent;
use App\Repositories\CourseRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Services\CourseService;
use App\Services\UserService;
use App\TeacherType;
use App\Traits\UploadFileTrait;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userRepo;
    protected $userService;
    protected $classroomRepo;
    protected $courseRepo;
    public function __construct(UserRepositoryEloquent $userRepo, UserService $userService, CourseRepositoryEloquent $courseRepo, ClassroomRepositoryEloquent $classroomRepo)
    {

        $this->userRepo = $userRepo;
        $this->userService = $userService;
        $this->classroomRepo = $classroomRepo;
        $this->courseRepo = $courseRepo;
    }
    public function index(Request $request)
    {
        $template = "backend.user.index";
        $config = $this->config();
        $params = $request->only(['page', 'limit']);
        $users = $this->userService->paginate($params);
        return view('layouts.admin', compact('template', 'config', 'users'));
    }

    public function create()
    {
        $template = 'backend.user.create';
        $teacher_type = TeacherType::labels();
        $classes = $this->classroomRepo->all();
        $courses = $this->courseRepo->all();
        $teacher_status = TeacherStatus::label();
        $config = $this->config();
        return view('layouts.admin', compact('template', 'config', 'teacher_type', 'teacher_status', 'classes', 'courses'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $request->except(['_token']);
        if ($this->userService->create($user)) {
            flash()->success('Đăng ký thành viên thành công.Vui lòng kiểm tra mail để kích hoạt tài khoản.');
            return redirect()->route('dashboard');
        }
        flash()->error('Đăng ký thành viên không thành công. Hãy thử lại.');
        return redirect()->route('dashboard');
    }

    public function edit($id)
    {
        $user = $this->userRepo->with(['courses', 'classes'])->find($id);
        $template = 'backend.user.edit';
        $courses = $this->courseRepo->all();
        $classes = $this->classroomRepo->all();
        $teacher_type = TeacherType::labels();
        $teacher_status = TeacherStatus::label();
        $config = $this->config();
        return view('layouts.admin', compact('template', 'config', 'user', 'teacher_type', 'teacher_status', 'courses', 'classes'));
    }

    public function update($id, Request $request)
    {
        if ($this->userService->update($id, $request)) {

            flash()->success('Cập nhật thành viên thành công');
            return redirect()->route('user.index');
        }
        flash()->error('Cập nhật thành viên không thành công. Hãy thử lại.');
        return redirect()->route('user.index');
    }

    public function delete($id)
    {
        $user = $this->userRepo->find($id);
        $template = 'backend.user.delete';
        $config = $this->config();
        return view('layouts.admin', compact('template', 'config', 'user'));
    }

    public function destroy($id)
    {
        if ($this->userService->delete($id)) {
            flash()->success('Xóa thành viên thành công');
            return redirect()->route('user.index');
        }
        flash()->error('Xóa thành viên không thành công. Hãy thử lại.');
        return redirect()->route('user.index');
    }

    public function profile($id)
    {

        $user = $this->userRepo->find($id, ['*']);

        if (!$user) {
            flash()->error('Không tìm thấy thông tin');
            return back();
        }

        $template = 'backend.user.profile';

        return view('layouts.admin', compact('template', 'user'));




    }

    public function filter(Request $request)
    {

        $template = 'backend.user.index';
        $filter = $request->all();
        $config = $this->config();
        $users = $this->userRepo->filter($filter);

        if ($users) {
            return view('layouts.admin', compact('template', 'config', 'users'));
        }

        if ($users->total() === 0) {
            return view('layouts.admin', compact('template', 'config'));
        }

        return abort(404, 'Không tìm thấy thông tin giáo viên');
    }
    private function config()
    {
        return [
            'breadcrumb' => [
                'index' => config('breadcrumb.user.index'),
                'create' => config('breadcrumb.user.create'),
                'edit' => config('breadcrumb.user.edit'),
                'delete' => config('breadcrumb.user.delete'),
            ],
            'tableHeading' => [
                'index' => config('breadcrumb.user.index')
            ]
        ];
    }
}
