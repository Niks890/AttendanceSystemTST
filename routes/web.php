<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceProductController;
use App\Http\Controllers\AttendanceTimeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ScannerAttendanceController;
use App\Http\Controllers\ScheduleShiftController;
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
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'postLogin'])->name('post.login');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::group(['prefix' => '', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/employee/search', [EmployeeController::class, 'search'])->name('employee.search');
    Route::resources([
        'employee' => EmployeeController::class,
        'attendance-time' => AttendanceTimeController::class,
        'attendance-product' => AttendanceProductController::class,
        'schedule-shift' => ScheduleShiftController::class,
    ]);
    Route::get('/attendance/check-in', [AttendanceTimeController::class, 'checkIn'])->name('attendance-time.check-in');
    Route::get('/attendance/scanner', [ScannerAttendanceController::class, 'index'])->name('scanner-attendance.index');
    Route::post('/attendance/scanner/upload', [ScannerAttendanceController::class, 'upload'])->name('scanner-attendance.upload');
    Route::post('/attendance/scanner/upload-json', [ScannerAttendanceController::class, 'uploadFromJson'])->name('scanner-attendance.upload-json');
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/events', [ScheduleController::class, 'getEvents']);

    Route::get('/export-excel', [ExportController::class, 'exportExcel'])->name('export.excel');

});
