<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Kehadiran Karyawan</h1>
         <a href="{{ route('attendance.create') }}">Add Attendance</a>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Tanggal</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Status Kehadiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendance as $attemployee)
                <tr>
                    <td>{{ $attemployee->employee->nama_lengkap ?? 'N/A' }}</td>
                    <td>{{ $attemployee->tanggal }}</td>
                    <td>{{ $attemployee->waktu_masuk ?? '-' }}</td>
                    <td>{{ $attemployee->waktu_keluar ?? '-' }}</td>
                    <td>{{ $attemployee->status_absensi }}</td>
                    <td>
                        <a href="{{ route('attendance.show', $attemployee->id) }}">Detail</a> |
                        <a href="{{ route('attendance.edit', $attemployee->id) }}">Edit</a> |
                        <form action="{{ route('attendance.destroy', $attemployee->id) }}" method="POST" style="display::inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        {{ $attendance->links() }}
    </div>
</body>
</html>