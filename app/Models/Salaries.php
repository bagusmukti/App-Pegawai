<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salaries extends Model
{
    protected $fillable = [
        'karyawan_id',
        'bulan',
        'gaji_pokok',
        // 'tunjangan',
        // 'potongan',
        // 'total_gaji',
    ];

    // Relasi ke Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }
}
