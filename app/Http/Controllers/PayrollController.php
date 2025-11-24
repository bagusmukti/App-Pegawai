<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        // Ambil karyawan sesuai role
        if (Auth::check() && Auth::user()->role === 'employee') {
            $me = Employee::where('email', Auth::user()->email)->first();
            $employees = $me ? collect([$me->load('position')]) : collect();
        } else {
            $employees = Employee::with('position')->get();
        }

        $payrollData = [];

        $workStart = config('payroll.work_start');
        $workEnd   = config('payroll.work_end');
        $lateDeductionPer15Min = (int) config('payroll.late_deduction_per_15min');
        $overtimePercentagePerHour = (float) config('payroll.overtime_percentage_per_hour');

        foreach ($employees as $employee) {
            $attendances = Attendance::where('karyawan_id', $employee->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->where('status_absensi', 'hadir')
                ->get(['tanggal','waktu_masuk','waktu_keluar']);

            $daysPresent = $attendances->count();
            $totalLateMinutes = 0;
            $totalOvertimeHours = 0;

            foreach ($attendances as $a) {
                if ($a->waktu_masuk) {
                    $in = Carbon::createFromFormat('H:i:s', $a->waktu_masuk);
                    $start = Carbon::createFromFormat('H:i:s', $workStart);
                    if ($in->greaterThan($start)) {
                        $totalLateMinutes += $start->diffInMinutes($in);
                    }
                }
                if ($a->waktu_keluar) {
                    $out = Carbon::createFromFormat('H:i:s', $a->waktu_keluar);
                    $end = Carbon::createFromFormat('H:i:s', $workEnd);
                    if ($out->greaterThan($end)) {
                        $overtimeMinutes = $end->diffInMinutes($out);
                        $totalOvertimeHours += floor($overtimeMinutes / 60); // Hitung per jam penuh
                    }
                }
            }

            // Potongan: setiap kelipatan 15 menit = Rp 50.000
            $lateIntervals = floor($totalLateMinutes / 15);
            $potongan = $lateIntervals * $lateDeductionPer15Min;
            
            // Tunjangan: setiap jam penuh = 5% dari gaji pokok
            $gajiPokok = (int) ($employee->position->gaji_pokok ?? 0);
            $tunjangan = $totalOvertimeHours * ($gajiPokok * $overtimePercentagePerHour);
            $totalSalary = max(0, $gajiPokok + $tunjangan - $potongan);

            $payrollData[] = [
                'nama_lengkap' => $employee->nama_lengkap,
                'jabatan' => $employee->position->nama_jabatan ?? '-',
                'gaji_pokok' => $gajiPokok,
                'hari_hadir' => $daysPresent,
                'menit_terlambat' => $totalLateMinutes,
                'kelipatan_15_menit' => $lateIntervals,
                'jam_lembur' => $totalOvertimeHours,
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

        if (Auth::check() && Auth::user()->role === 'employee') {
            $me = Employee::where('email', Auth::user()->email)->first();
            $employees = $me ? collect([$me->load('position')]) : collect();
        } else {
            $employees = Employee::with('position')->get();
        }

        $payrollData = [];

        $workStart = config('payroll.work_start');
        $workEnd   = config('payroll.work_end');
        $lateDeductionPer15Min = (int) config('payroll.late_deduction_per_15min');
        $overtimePercentagePerHour = (float) config('payroll.overtime_percentage_per_hour');

        foreach ($employees as $employee) {
            $attendances = Attendance::where('karyawan_id', $employee->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->where('status_absensi', 'hadir')
                ->get(['tanggal','waktu_masuk','waktu_keluar']);

            $daysPresent = $attendances->count();
            $totalLateMinutes = 0;
            $totalOvertimeHours = 0;

            foreach ($attendances as $a) {
                if ($a->waktu_masuk) {
                    $in = Carbon::createFromFormat('H:i:s', $a->waktu_masuk);
                    $start = Carbon::createFromFormat('H:i:s', $workStart);
                    if ($in->greaterThan($start)) {
                        $totalLateMinutes += $start->diffInMinutes($in);
                    }
                }
                if ($a->waktu_keluar) {
                    $out = Carbon::createFromFormat('H:i:s', $a->waktu_keluar);
                    $end = Carbon::createFromFormat('H:i:s', $workEnd);
                    if ($out->greaterThan($end)) {
                        $overtimeMinutes = $end->diffInMinutes($out);
                        $totalOvertimeHours += floor($overtimeMinutes / 60); // Hitung per jam penuh
                    }
                }
            }

            // Potongan: setiap kelipatan 15 menit = Rp 50.000
            $lateIntervals = floor($totalLateMinutes / 15);
            $potongan = $lateIntervals * $lateDeductionPer15Min;
            
            // Tunjangan: setiap jam penuh = 5% dari gaji pokok
            $gajiPokok = (int) ($employee->position->gaji_pokok ?? 0);
            $tunjangan = $totalOvertimeHours * ($gajiPokok * $overtimePercentagePerHour);
            $totalSalary = max(0, $gajiPokok + $tunjangan - $potongan);

            $payrollData[] = [
                'nama_lengkap' => $employee->nama_lengkap,
                'jabatan' => $employee->position->nama_jabatan ?? '-',
                'gaji_pokok' => $gajiPokok,
                'hari_hadir' => $daysPresent,
                'menit_terlambat' => $totalLateMinutes,
                'kelipatan_15_menit' => $lateIntervals,
                'jam_lembur' => $totalOvertimeHours,
                'potongan' => $potongan,
                'tunjangan' => $tunjangan,
                'total_gaji_bulanan' => $totalSalary,
            ];
        }

        $pdf = Pdf::loadView('payroll.pdf', compact('payrollData', 'month', 'year'))
            ->setPaper('A4', 'portrait');

        return $pdf->download("Rekap-Gaji-$month-$year.pdf");
    }

    // Removed myPayroll; employee filtering handled in index/export

}
