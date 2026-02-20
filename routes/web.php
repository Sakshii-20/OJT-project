<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BookController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// -------------------- Auth Routes --------------------
Route::get('/login', [AuthController::class,'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class,'login'])->middleware('guest')->name('login.submit');
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');

// -------------------- Registration Routes --------------------
Route::get('/student/register', [AuthController::class,'studentRegistration'])->middleware('guest')->name('auth.studentregistration');
Route::get('/admin/register', [AuthController::class,'adminRegistration'])->middleware('guest')->name('auth.adminregistration');
Route::post('/student/register', [AuthController::class,'registerStudent'])->middleware('guest')->name('student.register.post');
Route::post('/admin/register', [AuthController::class,'registerAdmin'])->middleware('guest')->name('admin.register.post');

// -------------------- Authenticated Routes --------------------
Route::middleware(['auth'])->group(function () {

    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
        Route::get('/admin/books', [AdminController::class,'getBooks']);
        Route::post('/admin/books', [AdminController::class,'storeBook']);
        Route::put('/admin/books/{id}', [AdminController::class,'updateBook']);
        Route::delete('/admin/books/{id}', [AdminController::class,'deleteBook']);
        Route::get('/students', [StudentController::class, 'getStudentsJson']);
    });

    // Student Routes
    Route::middleware(['role:student'])->group(function () {
        Route::get('/student/dashboard', [StudentController::class,'dashboard'])->name('student.dashboard');
        Route::get('/student/books', [StudentController::class, 'getBooks']);
        Route::get('/student/books/{id}', [StudentController::class, 'getBookDetails']);
    });
});
