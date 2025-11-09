<?php
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\SalariesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('employees.index');
});

Route::resource('employees', EmployeeController::class);
Route::resource('attendance', AttendanceController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('positions', PositionsController::class);
Route::resource('salaries', SalariesController::class);
