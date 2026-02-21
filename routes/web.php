<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DepartmentController;


Route::middleware('guest')->group(function () {

    Route::get('/', [LoginController::class, 'index'])->name('login');

    Route::get('/signup-page', [UserController::class, 'signupPage']);

    Route::post('/sign-up', [UserController::class, 'signup']);

    Route::post('/login', [UserController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'index']);

    Route::post('/password-reset-pin', [ForgotPasswordController::class, 'resetPin']);

    Route::post('/send-rest-link', [ForgotPasswordController::class, 'sendResetLink']);

    Route::post('/confirm-pin', [ForgotPasswordController::class, 'confirmPin']);

    Route::post('/submit-reset-password', [ForgotPasswordController::class, 'submitResetPassword']);

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

});


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'viewDashboard'])->middleware(PreventBackHistory::class);

    Route::get('/view-employees', [EmployeeController::class, 'viewEmployee'])->name('view-employees');

    Route::get('/add', [EmployeeController::class, 'addEmployeePage']);

    Route::get('/edit-employee/{employee}', [EmployeeController::class, 'editEmployee']);

    Route::put('/edit-employee/{employee}', [EmployeeController::class, 'updateEmployee']);

    Route::delete('/delete-employee/{employee}', [EmployeeController::class, 'deleteEmployee']);

    Route::post('/add-employee', [EmployeeController::class, 'addEmployee']);

    Route::post('/logout', [LogoutController::class,'logout']);

    Route::get('/department-status', [DepartmentController::class, 'index']);

    Route::get('/department-status/{id}', [DepartmentController::class, 'getStatus']);

});

