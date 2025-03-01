<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\editStudentController;
use App\Http\Controllers\ViewGradeController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public route (no middleware)
Route::get('/', function () {
    return view('welcome');
});

// Routes that require authentication
Route::middleware('auth')->group(function () {
    // Student routes - accessible by both roles
    Route::get('/viewgrade', [ViewGradeController::class, 'index'])->name('viewgrade.index');

    // Admin-only routes
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Subject routes
        Route::get('subject', [SubjectController::class, 'index'])->name('subject.index');
        Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::put('subjects/{subject_code}', [SubjectController::class, 'update'])->name('subjects.update');
        Route::delete('subject/{subject_code}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

        // Grade and Enrollment routes
        Route::get('grade', [GradeController::class, 'index'])->name('grade.index');
        Route::get('enrollment', [EnrollmentController::class, 'index'])->name('enrollment.index');

        // Enrollment store
        Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollment.store');

        // Student routes
        Route::get('students', [StudentController::class, 'index'])->name('student.index');
        Route::get('/editStudent/{student_id}', [StudentController::class, 'edit'])->name('editStudent.index');
        Route::delete('/student/{student}', [StudentController::class, 'destroy'])->name('student.destroy');

        // Grade routes
        Route::get('/grades/{student_id}', [GradeController::class, 'index'])->name('grade.index');
        Route::post('/grade/store', [GradeController::class, 'store'])->name('grade.store');

        // Profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
    });
});

require __DIR__.'/auth.php';
