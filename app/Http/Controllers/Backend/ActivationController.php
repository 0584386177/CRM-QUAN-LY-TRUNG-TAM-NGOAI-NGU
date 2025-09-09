<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Http\Request;

class ActivationController extends Controller
{

    protected $userRepo;

    public function __construct(UserRepositoryEloquent $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register($token)
    {
        $user = $this->userRepo->findWhere([['activation_token', '=', $token]])->first;

        if ($user) {
            $user->status = true;
            unset($user->activation_token);
            flash()->success('Kích hoạt tài khoản thành công');
            return redirect()->route('dashboard');
        }
        $user->status = false;
        flash()->success('Kích hoạt tài khoản không thành công');
        return redirect()->route('dashboard');
    }
}
