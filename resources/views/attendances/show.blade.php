<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Kehadiran Pegawai</title>
</head>
<body>
    <h1>Detail Kehadiran Pegawai</h1>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $attendance->employee->nama_lengkap ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $attendance->tanggal }}</td>
        </tr>
        <tr>
            <th>Waktu Masuk</th>
            <td>{{ $attendance->waktu_masuk }}</td>
        </tr>
        <tr>
            <th>Waktu Keluar</th>
            <td>{{ $attendance->waktu_keluar }}</td>
        </tr>
        <tr>
            <th>Status Absensi</th>
            <td>{{ $attendance->status_absensi }}</td>
        </tr>
    </table>
</body>
</html>