<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Jabatan</title>
</head>

<body>
    @extends('master')
    @section('title', 'Detail Jabatan Pegawai')
    @section('page-title', 'Detail Jabatan')
    @section('content')

        <h1 class="page-title">Detail Jabatan</h1>
        <table class="detail-table">
            <tr>
                <th>Nama Jabatan</th>
                <td>{{ $positions->nama_jabatan }}</td>
            </tr>
            <tr>
                <th>Gaji Pokok</th>
                <td>{{ $positions->gaji_pokok }}</td>
            </tr>
        </table>
        <div class="detail-actions">
            <a href="{{ route('positions.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    @endsection
</body>

</html>
