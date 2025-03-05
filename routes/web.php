<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'postLogin'])->name('post.login');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::group(['prefix' => '', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resources([
        'employee' => EmployeeController::class
    ]);

    Route::get('/employee/search', [EmployeeController::class, 'search'])->name('employee.search');
});
