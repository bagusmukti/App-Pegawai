<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Jabatan</title>
</head>

<body>
    @extends('master')
    @section('title', 'Edit Data Jabatan Pegawai')
    @section('page-title', 'Edit Jabatan')
    @section('content')

        <h2 class="form-title">Edit Data Jabatan</h2>

        <form class="form-container" action="{{ route('positions.update', $positions->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="form-table">
                <tr>
                    <td>Nama Jabatan</td>
                    <td><input type="text" name="nama_jabatan" class="form-input"
                            value="{{ old('nama_jabatan', $positions->nama_jabatan) }}"></td>
                </tr>
                <tr>
                    <td>Gaji Pokok</td>
                    <td><input type="text" name="gaji_pokok" class="form-input"
                            value="{{ old('gaji_pokok', $positions->gaji_pokok) }}"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="form-table-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </td>
                </tr>
            </table>
        </form>
    @endsection
</body>

</html>
