<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'departemen_id',
        'jabatan_id',
        'status',
    ];

    //Relasi ke Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'departemen_id');
    }

    // Relasi ke Position
    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }

    // Relasi ke Attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'karyawan_id');
    }

    // Relasi ke Salaries
    public function salaries()
    {
        return $this->hasMany(Salaries::class, 'karyawan_id');
    }
}
