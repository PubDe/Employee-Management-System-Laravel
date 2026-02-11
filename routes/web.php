<?php

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ForgotPasswordController;

Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/forgot-password', [UserController::class, 'signupPage']);

    Route::get('/signup-page', [UserController::class, 'signupPage']);

    Route::post('/sign-up', [UserController::class, 'signup']);

    Route::post('/login', [UserController::class, 'login']);

    Route::post('/password-reset-pin', [ForgotPasswordController::class, 'resetPin']);

    Route::post('/send-rest-link', [ForgotPasswordController::class, 'sendResetLink']);

    Route::post('/confirm-pin', [ForgotPasswordController::class, 'confirmPin']);

    Route::post('/submit-reset-password', [ForgotPasswordController::class, 'submitResetPassword']);

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token'=>$token]);
    })->name('password.reset');

    Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
    });
});


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(PreventBackHistory::class);

    Route::get('/view-employees', function () {
        $employees = Employee::paginate(5);
        return view('view-employees', ['employees'=>$employees]);
    });

    Route::get('/add', function () {
        return view('add-employee');
    });

    Route::get('/edit-employee/{employee}', [EmployeeController::class, 'editEmployee']);

    Route::put('/edit-employee/{employee}', [EmployeeController::class, 'updateEmployee']);

    Route::delete('/delete-employee/{employee}', [EmployeeController::class, 'deleteEmployee']);

    Route::post('/add-employee', [EmployeeController::class, 'addEmployee']);

    Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
    });


});

