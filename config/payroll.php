<?php

return [
    // Jam kerja standar
    'work_start' => env('PAYROLL_WORK_START', '09:00:00'),
    'work_end'   => env('PAYROLL_WORK_END', '15:00:00'),

    // Sistem potongan keterlambatan (per kelipatan 15 menit)
    'late_deduction_per_15min' => env('PAYROLL_LATE_DEDUCTION_PER_15MIN', 50000),
    
    // Sistem tunjangan lembur (per kelipatan 1 jam = 5% dari gaji pokok)
    'overtime_percentage_per_hour' => env('PAYROLL_OVERTIME_PERCENTAGE_PER_HOUR', 0.05),

    // Hari kerja standar untuk prorata (jika dipakai di masa depan)
    'standard_work_days' => env('PAYROLL_STANDARD_WORK_DAYS', 22),
];
