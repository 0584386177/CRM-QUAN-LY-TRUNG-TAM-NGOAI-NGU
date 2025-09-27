<?php

use App\Exports\StudentExport;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\ActivationController;
use App\Http\Controllers\Backend\ClassroomController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\TuitionController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');




    Route::middleware(['isManager'])->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user.index');
            Route::get('/create', [UserController::class, 'create'])->name('user.create');
            Route::post('/store', [UserController::class, 'store'])->name('user.store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
            Route::post('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
            Route::get('/profile/{id}', [UserController::class, 'profile'])->name('user.profile');
            Route::get('filter/', [UserController::class, 'filter'])->name('user.filter');
        });
    });

    Route::prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('/create', [StudentController::class, 'create'])->name('student.create');
        Route::post('/store', [StudentController::class, 'store'])->name('student.store');
        Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
        Route::post('/update/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::get('/delete/{id}', [StudentController::class, 'delete'])->name('student.delete');
        Route::post('/destroy/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
        Route::get('/profile/{id}', [ProfileController::class, 'student'])->name('profile.index');
        Route::post('/payment/{id}', [PaymentController::class, 'updateTuitionStudent'])->name('student.tuition.update');
        Route::get('export/xlsx', [StudentController::class, 'exportXLSX'])->name('students.export.xlsx');

    });


    Route::prefix('course')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('course.index');
        Route::get('/create', [CourseController::class, 'create'])->name('course.create');
        Route::post('/store', [CourseController::class, 'store'])->name('course.store');
        Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
        Route::post('/update/{id}', [CourseController::class, 'update'])->name('course.update');
        Route::get('/delete/{id}', [CourseController::class, 'delete'])->name('course.delete');
        Route::post('/destroy/{id}', [CourseController::class, 'destroy'])->name('course.destroy');
        Route::get('filter/', [CourseController::class, 'filter'])->name('course.filter');
    });

    Route::prefix('classroom')->group(function () {
        Route::get('/', [ClassroomController::class, 'index'])->name('classroom.index');
        Route::get('/create', [ClassroomController::class, 'create'])->name('classroom.create');
        Route::post('/store', [ClassroomController::class, 'store'])->name('classroom.store');
        Route::get('/edit/{id}', [ClassroomController::class, 'edit'])->name('classroom.edit');
        Route::post('/update/{id}', [ClassroomController::class, 'update'])->name('classroom.update');
        Route::get('/delete/{id}', [ClassroomController::class, 'delete'])->name('classroom.delete');
        Route::post('/destroy/{id}', [ClassroomController::class, 'destroy'])->name('classroom.destroy');
        Route::get('filter/', [ClassroomController::class, 'filter'])->name('classroom.filter');
    });
    Route::prefix('tuition')->group(function () {
        Route::get('/', [TuitionController::class, 'index'])->name('tuition.index');

    });


    Route::get('/activate/{token}', [ActivationController::class, 'register'])->name('activate.register.user');
});

// AJAX


require __DIR__ . '/auth.php';
