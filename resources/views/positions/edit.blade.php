<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Jabatan</title>
</head>
<body>
    <h2>Edit Data Jabatan</h2>
    <form action="{{ route('positions.update', $positions->id) }}" method="POST">
        @csrf
        @method('PUT')
        <table>
            <tr>
                <td>Nama Jabatan</td>
                <td><input type="text" name="nama_jabatan" value="{{ old('nama_jabatan', $positions->nama_jabatan) }}"></td>
            </tr>
            <tr>
                <td>Gaji Pokok</td>
                <td><input type="text" name="gaji_pokok" value="{{ old('gaji_pokok', $positions->gaji_pokok) }}"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Update</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>