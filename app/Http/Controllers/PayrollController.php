<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

    // Ambil semua karyawan + relasi jabatan
    $employees = Employee::with('position')->get();

        $payrollData = [];

        $workStart = config('payroll.work_start');
        $workEnd   = config('payroll.work_end');
        $lateRate  = (int) config('payroll.late_deduction_per_min');
        $overRate  = (int) config('payroll.overtime_allow_per_min');

        foreach ($employees as $employee) {
            $attendances = Attendance::where('karyawan_id', $employee->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->where('status_absensi', 'hadir')
                ->get(['tanggal','waktu_masuk','waktu_keluar']);

            $daysPresent = $attendances->count();
            $lateMinutes = 0;
            $overtimeMinutes = 0;

            foreach ($attendances as $a) {
                if ($a->waktu_masuk) {
                    $in = Carbon::createFromFormat('H:i:s', $a->waktu_masuk);
                    $start = Carbon::createFromFormat('H:i:s', $workStart);
                    if ($in->greaterThan($start)) {
                        $lateMinutes += $start->diffInMinutes($in);
                    }
                }
                if ($a->waktu_keluar) {
                    $out = Carbon::createFromFormat('H:i:s', $a->waktu_keluar);
                    $end = Carbon::createFromFormat('H:i:s', $workEnd);
                    if ($out->greaterThan($end)) {
                        $overtimeMinutes += $end->diffInMinutes($out);
                    }
                }
            }

            $potongan = $lateMinutes * $lateRate;
            $tunjangan = $overtimeMinutes * $overRate;
            $gajiPokok = (int) ($employee->position->gaji_pokok ?? 0);
            $totalSalary = max(0, $gajiPokok + $tunjangan - $potongan);

            $payrollData[] = [
                'nama_lengkap' => $employee->nama_lengkap,
                'jabatan' => $employee->position->nama_jabatan ?? '-',
                'gaji_pokok' => $gajiPokok,
                'hari_hadir' => $daysPresent,
                'menit_terlambat' => $lateMinutes,
                'menit_lembur' => $overtimeMinutes,
                'potongan' => $potongan,
                'tunjangan' => $tunjangan,
                'total_gaji_bulanan' => $totalSalary,
            ];
        }

        return view('payroll.index', compact('payrollData', 'month', 'year'));
    }

    public function exportPdf(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

    $employees = Employee::with('position')->get();

        $payrollData = [];

        $workStart = config('payroll.work_start');
        $workEnd   = config('payroll.work_end');
        $lateRate  = (int) config('payroll.late_deduction_per_min');
        $overRate  = (int) config('payroll.overtime_allow_per_min');

        foreach ($employees as $employee) {
            $attendances = Attendance::where('karyawan_id', $employee->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->where('status_absensi', 'hadir')
                ->get(['tanggal','waktu_masuk','waktu_keluar']);

            $daysPresent = $attendances->count();
            $lateMinutes = 0;
            $overtimeMinutes = 0;

            foreach ($attendances as $a) {
                if ($a->waktu_masuk) {
                    $in = Carbon::createFromFormat('H:i:s', $a->waktu_masuk);
                    $start = Carbon::createFromFormat('H:i:s', $workStart);
                    if ($in->greaterThan($start)) {
                        $lateMinutes += $start->diffInMinutes($in);
                    }
                }
                if ($a->waktu_keluar) {
                    $out = Carbon::createFromFormat('H:i:s', $a->waktu_keluar);
                    $end = Carbon::createFromFormat('H:i:s', $workEnd);
                    if ($out->greaterThan($end)) {
                        $overtimeMinutes += $end->diffInMinutes($out);
                    }
                }
            }

            $potongan = $lateMinutes * $lateRate;
            $tunjangan = $overtimeMinutes * $overRate;
            $gajiPokok = (int) ($employee->position->gaji_pokok ?? 0);
            $totalSalary = max(0, $gajiPokok + $tunjangan - $potongan);

            $payrollData[] = [
                'nama_lengkap' => $employee->nama_lengkap,
                'jabatan' => $employee->position->nama_jabatan ?? '-',
                'gaji_pokok' => $gajiPokok,
                'hari_hadir' => $daysPresent,
                'menit_terlambat' => $lateMinutes,
                'menit_lembur' => $overtimeMinutes,
                'potongan' => $potongan,
                'tunjangan' => $tunjangan,
                'total_gaji_bulanan' => $totalSalary,
            ];
        }

        $pdf = Pdf::loadView('payroll.pdf', compact('payrollData', 'month', 'year'))
            ->setPaper('A4', 'portrait');

        return $pdf->download("Rekap-Gaji-$month-$year.pdf");
    }
}
