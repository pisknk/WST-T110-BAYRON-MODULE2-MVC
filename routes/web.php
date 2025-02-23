<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('subject', [SubjectController::class, 'index'])->middleware(['auth', 'verified'])->name('subject.index');
Route::get('grade', [GradeController::class, 'index'])->middleware(['auth', 'verified'])->name('grade.index');
Route::get('enrollment', [EnrollmentController::class, 'index'])->middleware(['auth', 'verified'])->name('enrollment.index');

Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollment.store');

Route::get('students', [StudentController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('student.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
