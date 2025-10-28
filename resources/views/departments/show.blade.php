<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Departemen</title>
</head>

<body>
    @extends('master')
    @section('title', 'Detail Departemen Pegawai')
    @section('page-title', 'Detail Departemen')
    @section('content')

        <h1 class="page-title">Detail Departemen</h1>

        <table class="detail-table">
            <tr>
                <th>Nama Departemen</th>
                <td>{{ $departments->nama_departemen }}</td>
            </tr>
        </table>
        <div class="detail-actions">
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    @endsection
</body>

</html>
