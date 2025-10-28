<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai</title>
</head>

<body>
    @extends('master')
    @section('title', 'Detail Data Pegawai')
    @section('page-title', 'Detail Pegawai')
    @section('content')

        <h1 class="page-title">Detail Pegawai</h1>
        <table class="detail-table">
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $employee->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $employee->email }}</td>
            </tr>
            <tr>
                <th>Nomor Telepon</th>
                <td>{{ $employee->nomor_telepon }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $employee->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $employee->alamat }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{ $employee->tanggal_masuk }}</td>
            </tr>
            <tr>
                <th>Departemen</th>
                <td>{{ $employee->department->nama_departemen ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{{ $employee->position->nama_jabatan ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $employee->status }}</td>
            </tr>
        </table>
        <div class="form-actions" style="text-align: left; max-width: 700px;">
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    @endsection
</body>

</html>
