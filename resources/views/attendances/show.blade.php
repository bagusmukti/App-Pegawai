@extends('master')
    @section('title', 'Detail Kehadiran Pegawai')
    @section('page-title', 'Detail Absensi')
    @section('content')

        <h1 class="page-title">Detail Kehadiran Pegawai</h1>
        <table class="detail-table">
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $attendance->employee->nama_lengkap ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ $attendance->tanggal }}</td>
            </tr>
            <tr>
                <th>Waktu Masuk</th>
                <td>{{ $attendance->waktu_masuk }}</td>
            </tr>
            <tr>
                <th>Waktu Keluar</th>
                <td>{{ $attendance->waktu_keluar }}</td>
            </tr>
            <tr>
                <th>Status Absensi</th>
                <td>{{ $attendance->status_absensi }}</td>
            </tr>
        </table>
        <div class="detail-actions">
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    @endsection
