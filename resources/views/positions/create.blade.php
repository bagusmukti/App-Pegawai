<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Input Jabatan</title>
</head>

<body>
    @extends('master')
    @section('title', 'Form Jabatan Pegawai')
    @section('page-title', 'Tambah Jabatan')
    @section('content')

        <h1 class="form-title">Form Jabatan</h1>

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form-container" action="{{ route('positions.store') }}" method="POST">
            @csrf
            <table class="form-table">
                <tr>
                    <td><label for="nama_jabatan">Nama Jabatan:</label></td>
                    <td><input type="text" name="nama_jabatan" id="nama_jabatan" class="form-input" required></td>
                </tr>
                <tr>
                    <td><label for="gaji_pokok">Gaji Pokok:</label></td>
                    <td><input type="text" name="gaji_pokok" id="gaji_pokok" class="form-input"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="form-table-actions">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </td>
                </tr>
            </table>
        </form>
    @endsection
</body>

</html>
