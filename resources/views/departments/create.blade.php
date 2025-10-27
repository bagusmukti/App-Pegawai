<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Input Departemen</title>
</head>
<body>
    <h1>Form Departemen</h1>
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <table>
            <tr>
                <td><label for="nama_departemen">Nama Departemen:</label></td>
                <td><input type="text" name="nama_departemen" id="nama_departemen" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right;">
                    <button type="submit">Simpan</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>