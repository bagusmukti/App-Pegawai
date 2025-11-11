<?php
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('employees.index');
});

Route::resource('employees', EmployeeController::class);
// IMPORTANT: Letakkan route custom sebelum resource agar tidak tertangkap oleh /attendance/{attendance}
Route::get('/attendance/check', [AttendanceController::class, 'check'])->name('attendance.check');
Route::post('/attendance/waktu-masuk', [AttendanceController::class, 'storeMasuk'])->name('attendance.masuk');
Route::post('/attendance/waktu-keluar', [AttendanceController::class, 'storeKeluar'])->name('attendance.keluar');
Route::resource('attendance', AttendanceController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('positions', PositionsController::class);
Route::resource('salaries', SalariesController::class);
Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
Route::get('/payroll/export/pdf', [PayrollController::class, 'exportPdf'])->name('payroll.export.pdf');