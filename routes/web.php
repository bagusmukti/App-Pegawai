<?php
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\MoodTrackerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // return redirect()->route('login');
    // 1. Cek dulu apakah user SUDAH login
    if (Auth::check()) {
        
        // 2. Jika sudah, arahkan berdasarkan role mereka
        if (Auth::user()->role === 'admin') {
            return redirect()->route('employees.index');
        } else {
            return redirect()->route('attendance.check');
        }
    }

    // 3. Jika BELUM login, baru arahkan ke halaman login
    return redirect()->route('login');
});

// Route::resource('employees', EmployeeController::class);
// // IMPORTANT: Letakkan route custom sebelum resource agar tidak tertangkap oleh /attendance/{attendance}
// Route::get('/attendance/check', [AttendanceController::class, 'check'])->name('attendance.check');
// Route::post('/attendance/waktu-masuk', [AttendanceController::class, 'storeMasuk'])->name('attendance.masuk');
// Route::post('/attendance/waktu-keluar', [AttendanceController::class, 'storeKeluar'])->name('attendance.keluar');
// Route::resource('attendance', AttendanceController::class);
// Route::resource('departments', DepartmentController::class);
// Route::resource('positions', PositionsController::class);
// Route::resource('salaries', SalariesController::class);
// Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
// Route::get('/payroll/export/pdf', [PayrollController::class, 'exportPdf'])->name('payroll.export.pdf');

// Admin routes - Full access
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionsController::class);
    Route::resource('salaries', SalariesController::class);
    
    // Attendance routes untuk admin
    Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/admin/attendance/create', [AttendanceController::class, 'create'])->name('admin.attendance.create');
    Route::post('/admin/attendance', [AttendanceController::class, 'store'])->name('admin.attendance.store');
    Route::get('/admin/attendance/{id}', [AttendanceController::class, 'show'])->name('admin.attendance.show');
    Route::get('/admin/attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('admin.attendance.edit');
    Route::put('/admin/attendance/{id}', [AttendanceController::class, 'update'])->name('admin.attendance.update');
    Route::delete('/admin/attendance/{id}', [AttendanceController::class, 'destroy'])->name('admin.attendance.destroy');
    Route::get('/attendance-check', [AttendanceController::class, 'check'])->name('admin.attendance.check');
    Route::post('/attendance-masuk', [AttendanceController::class, 'storeMasuk'])->name('admin.attendance.masuk');
    Route::post('/attendance-keluar', [AttendanceController::class, 'storeKeluar'])->name('admin.attendance.keluar');
    
    // Payroll routes untuk admin
    Route::get('/admin/payroll', [PayrollController::class, 'index'])->name('admin.payroll.index');
    Route::get('/admin/payroll/export/pdf', [PayrollController::class, 'exportPdf'])->name('admin.payroll.export');
    
    // Announcements routes untuk admin (CRUD lengkap)
    Route::resource('/admin/announcements', AnnouncementController::class, [
        'names' => [
            'index' => 'admin.announcements.index',
            'create' => 'admin.announcements.create',
            'store' => 'admin.announcements.store',
            'show' => 'admin.announcements.show',
            'edit' => 'admin.announcements.edit',
            'update' => 'admin.announcements.update',
            'destroy' => 'admin.announcements.destroy'
        ]
    ]);
    
    // Mood Tracker routes untuk admin (analytics & management)
    Route::get('/admin/mood-tracker', [MoodTrackerController::class, 'index'])->name('admin.mood-tracker.index');
    Route::get('/admin/mood-tracker/{id}', [MoodTrackerController::class, 'show'])->name('admin.mood-tracker.show');
    Route::delete('/admin/mood-tracker/{id}', [MoodTrackerController::class, 'destroy'])->name('admin.mood-tracker.destroy');
});

// Employee routes - Limited access
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/my-attendance/check', [AttendanceController::class, 'check'])->name('attendance.check');
    Route::post('/my-attendance/masuk', [AttendanceController::class, 'storeMasuk'])->name('attendance.masuk');
    Route::post('/my-attendance/keluar', [AttendanceController::class, 'storeKeluar'])->name('attendance.keluar');
    Route::get('/my-attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    
    // Payroll untuk employee (hanya lihat milik sendiri)
    Route::get('/my-payroll', [PayrollController::class, 'index'])->name('payroll.index');
    
    // Announcements routes untuk employee (read-only)
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');
    
    // Mood Tracker routes untuk employee (input & view own moods)
    Route::resource('mood-tracker', MoodTrackerController::class, [
        'except' => ['destroy'] // Employee tidak bisa delete mood entries
    ]);
});

// login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');