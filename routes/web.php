<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\ActivationController;
use App\Http\Controllers\Backend\ClassroomController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\SubjectController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ProfileController;
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
        Route::get('filter/', [StudentController::class, 'filter'])->name('student.filter');
    });

    Route::prefix('subject')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('subject.index');
        Route::get('/create', [SubjectController::class, 'create'])->name('subject.create');
        Route::post('/store', [SubjectController::class, 'store'])->name('subject.store');
        Route::get('/edit/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
        Route::post('/update/{id}', [SubjectController::class, 'update'])->name('subject.update');
        Route::get('/delete/{id}', [SubjectController::class, 'delete'])->name('subject.delete');
        Route::post('/destroy/{id}', [SubjectController::class, 'destroy'])->name('subject.destroy');
        Route::get('filter/', [SubjectController::class, 'filter'])->name('subject.filter');
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

    Route::get('/activate/{token}', [ActivationController::class, 'register'])->name('activate.register.user');
});


require __DIR__ . '/auth.php';
