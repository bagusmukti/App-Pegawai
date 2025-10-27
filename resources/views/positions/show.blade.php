<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Jabatan</title>
</head>
<body>
    <h1>Detail Jabatan</h1>
    <table border="1" cellpadding="8" cellspacing="0">
         <tr>
            <th>Nama Jabatan</th>
            <td>{{ $positions->nama_jabatan }}</td>
        </tr>
        <tr>
            <th>Gaji Pokok</th>
            <td>{{ $positions->gaji_pokok }}</td>
        </tr>
    </table>
</body>
</html>