<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Input Departemen</title>
</head>

<body>
    @extends('master')
    @section('title', 'Form Departemen Pegawai')
    @section('page-title', 'Tambah Departemen')
    @section('content')

        <h1 class="form-title">Form Departemen</h1>

        <form class="form-container" action="{{ route('departments.store') }}" method="POST">
            @csrf
            <table class="form-table">
                <tr>
                    <td><label for="nama_departemen">Nama Departemen:</label></td>
                    <td><input type="text" name="nama_departemen" id="nama_departemen" class="form-input" required></td>
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
