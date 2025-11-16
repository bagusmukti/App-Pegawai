<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Departemen</title>
</head>

<body>
    @extends('master')
    @section('title', 'Form Edit Departemen Pegawai')
    @section('page-title', 'Edit Departemen')
    @section('content')

        <h2 class="form-title">Edit Data Departemen</h2>

        <form class="form-container" action="{{ route('departments.update', $departments->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="form-table">
                <tr>
                    <td>Nama Departemen</td>
                    <td><input type="text" name="nama_departemen" class="form-input"
                            value="{{ old('nama_departemen', $departments->nama_departemen) }}"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="form-table-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </td>
                </tr>
                <div class="detail-actions">
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                </div>
            </table>
        </form>
    @endsection
</body>

</html>
