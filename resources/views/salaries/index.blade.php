<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slip Gaji Karyawan</title>
</head>
<body>
    <h1>Slip Gaji Karyawan</h1>
    <a href="{{ route('salaries.create') }}">Add Salaries</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Bulan</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Potongan</th>
                <th>Total Gaji</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaries as $sal)
            <tr>
                <td>{{ $sal->employee->nama_lengkap ?? 'N/A' }}</td>
                <td>{{ $sal->bulan }}</td>
                <td>{{ $sal->gaji_pokok }}</td>
                <td>{{ $sal->tunjangan }}</td>
                <td>{{ $sal->potongan }}</td>
                <td>{{ $sal->total_gaji }}</td>
                <td>
                    <a href="{{ route('salaries.show', $sal->id) }}">Detail</a> |
                    <a href="{{ route('salaries.edit', $sal->id) }}">Edit</a> |
                    <form action="{{ route('salaries.destroy', $sal->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>