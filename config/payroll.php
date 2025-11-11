<?php

return [
    // Jam kerja standar
    'work_start' => env('PAYROLL_WORK_START', '09:00:00'),
    'work_end'   => env('PAYROLL_WORK_END', '17:00:00'),

    // Tarif per menit (Rupiah)
    'late_deduction_per_min' => env('PAYROLL_LATE_DEDUCTION_PER_MIN', 1000),
    'overtime_allow_per_min' => env('PAYROLL_OVERTIME_ALLOW_PER_MIN', 1500),

    // Hari kerja standar untuk prorata (jika dipakai di masa depan)
    'standard_work_days' => env('PAYROLL_STANDARD_WORK_DAYS', 22),
];
