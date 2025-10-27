<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Posisi</title>
</head>
<body>
    <div>
        <h1>Daftar Posisi</h1>
        <a href="{{ route('positions.create') }}">Add Positions</a>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Jabatan</th>
                    <th>Gaji Pokok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($positions as $pos)
                <tr>
                    <td>{{ $pos->nama_jabatan }}</td>
                     <td>Rp {{ number_format($pos->gaji_pokok, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('positions.show', $pos->id) }}">Detail</a> |
                        <a href="{{ route('positions.edit', $pos->id) }}">Edit</a> |
                        <form action="{{ route('positions.destroy', $pos->id) }}" method="POST" style="display:inline;">
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
        {{ $positions->links() }}
    </div>
</body>
</html>