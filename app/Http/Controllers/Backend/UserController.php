<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\ClassroomRepositoryEloquent;
use App\Repositories\SubjectRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use App\Services\SubjectService;
use App\Services\UserService;
use App\TeacherType;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userRepo;
    protected $userService;
    protected $classroomRepo;
    protected $subjectRepo;
    public function __construct(UserRepositoryEloquent $userRepo, UserService $userService, SubjectRepositoryEloquent $subjectRepo, ClassroomRepositoryEloquent $classroomRepo)
    {

        $this->userRepo = $userRepo;
        $this->userService = $userService;
        $this->classroomRepo = $classroomRepo;
        $this->subjectRepo = $subjectRepo;
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
        $subjects = $this->subjectRepo->all();
        $config =  $this->config();
        return view('layouts.admin', compact('template', 'config', 'teacher_type', 'classes', 'subjects'));
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
        $user = $this->userRepo->with(['subjects', 'classes'])->find($id);
        $template = 'backend.user.edit';
        $subjects = $this->subjectRepo->all();
        $classes = $this->classroomRepo->all();
        $teacher_type = TeacherType::labels();
        $config =  $this->config();
        return view('layouts.admin', compact('template', 'config', 'user', 'teacher_type', 'subjects', 'classes'));
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
        $config =  $this->config();
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
