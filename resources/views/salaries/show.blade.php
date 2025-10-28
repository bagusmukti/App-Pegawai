<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Slip Gaji</title>
</head>

<body>
    @extends('master')
    @section('title', 'Detail Gaji Pegawai')
    @section('page-title', 'Detail Slip Gaji')
    @section('content')

        <h1 class="page-title">Detail Slip Gaji</h1>

        <table class="detail-table">
            <tr>
                <th>Nama Karyawan</th>
                <td>{{ $salaries->employee->nama_lengkap ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Bulan</th>
                <td>{{ $salaries->bulan }}</td>
            </tr>
            <tr>
                <th>Gaji Pokok</th>
                <td>{{ $salaries->gaji_pokok }}</td>
            </tr>
            <tr>
                <th>Tunjangan</th>
                <td>{{ $salaries->tunjangan }}</td>
            </tr>
            <tr>
                <th>Potongan</th>
                <td>{{ $salaries->potongan }}</td>
            </tr>
            <tr>
                <th>Total Gaji</th>
                <td>{{ $salaries->total_gaji }}</td>
            </tr>
        </table>
        <div class="detail-actions">
            <a href="{{ route('salaries.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    @endsection
</body>

</html>
