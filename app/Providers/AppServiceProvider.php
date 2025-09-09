<?php

namespace App\Providers;

use App\Repositories\ClassroomRepository;
use App\Repositories\ClassroomRepositoryEloquent;
use App\Repositories\StudentRepository;
use App\Repositories\StudentRepositoryEloquent;
use App\Repositories\SubjectRepository;
use App\Repositories\SubjectRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Services\ClassroomService;
use App\Services\Interfaces\ClassroomServiceInterface;
use App\Services\Interfaces\StudentServiceInterface;
use App\Services\Interfaces\SubjectServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\StudentService;
use App\Services\SubjectService;
use App\Services\UserService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $serviceBindings = [
        UserServiceInterface::class => UserService::class,
        UserRepository::class => UserRepositoryEloquent::class,
        StudentServiceInterface::class => StudentService::class,
        StudentRepository::class => StudentRepositoryEloquent::class,
        SubjectServiceInterface::class => SubjectService::class,
        SubjectRepository::class => SubjectRepositoryEloquent::class,
        ClassroomServiceInterface::class => ClassroomService::class,
        ClassroomRepository::class => ClassroomRepositoryEloquent::class,


    ];
    public function register(): void
    {
        foreach ($this->serviceBindings as $key => $value) {
            $this->app->bind($key, $value);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Blade::directive('price', fn($exp) =>
        "\\App\\Helpers\\Helper::formatPrice($exp)");
    }
}
