<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $attendance = Attendance::with('employee')->latest()->paginate(5);
        return view('attendances.index', compact('attendance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('attendances.create', compact ('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id'       => 'required|exists:employees,id',
            'tanggal'           => 'required|date',
            'waktu_masuk'       => 'nullable',
            'waktu_keluar'      => 'nullable',
            'status_absensi'    => 'required|in:hadir,izin,sakit,alpha',
        ]);
        Attendance::create($request->all());
        return redirect()->route('attendance.index');
    }

    public function check(Request $request)
    {
        $employeeId = $request->query('karyawan_id');
        $employees = Employee::all();

        $todayAttendance = null;
        if ($employeeId) {
            $todayAttendance = Attendance::where('karyawan_id', $employeeId)
                ->whereDate('tanggal', now())
                ->first();
        }

        return view('attendances.check', compact('todayAttendance', 'employees', 'employeeId'));
    }

    public function storeMasuk(Request $request)
    {
        $data = $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
        ]);

        $existing = Attendance::where('karyawan_id', $data['karyawan_id'])
            ->whereDate('tanggal', now())
            ->first();

        if ($existing && $existing->waktu_masuk) {
            return back()->with('error', 'Anda sudah absen masuk hari ini.');
        }

        if ($existing) {
            $existing->update([
                'waktu_masuk' => now()->toTimeString(),
                'status_absensi' => 'hadir',
            ]);
        } else {
            Attendance::create([
                'karyawan_id' => $data['karyawan_id'],
                'tanggal' => now()->toDateString(),
                'waktu_masuk' => now()->toTimeString(),
                'status_absensi' => 'hadir',
            ]);
        }

        return back()->with('success', 'Absen masuk berhasil!');
    }

    public function storeKeluar(Request $request)
    {
        $data = $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
        ]);

        $attendance = Attendance::where('karyawan_id', $data['karyawan_id'])
            ->whereDate('tanggal', now())
            ->first();

        if (!$attendance || !$attendance->waktu_masuk) {
            return back()->with('error', 'Absen masuk belum tercatat untuk hari ini.');
        }

        if ($attendance->waktu_keluar) {
            return back()->with('error', 'Anda sudah absen pulang hari ini.');
        }

        $attendance->update([
            'waktu_keluar' => now()->toTimeString(),
        ]);

        return back()->with('success', 'Absen pulang berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);
        return view('attendances.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        return view('attendances.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'karyawan_id'       => 'required|exists:employees,id',
            'tanggal'           => 'required|date',
            'waktu_masuk'       => 'nullable',
            'waktu_keluar'      => 'nullable',
            'status_absensi'    => 'required|in:hadir,izin,sakit,alpha',
        ]);
        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->all());
        return redirect()->route('attendance.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return redirect()->route('attendance.index');
    }
}
