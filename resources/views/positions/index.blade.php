<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Posisi</title>
</head>

<body>
    @extends('master')
    @section('title', 'Daftar Jabatan Pegawai')
    @section('page-title', 'Daftar Jabatan')
    @section('content')

        <h1 class="page-title">Daftar Posisi</h1>

        <div class="add-button-container">
            <a href="{{ route('positions.create') }}" class="btn btn-primary">Add Positions</a>
        </div>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nama Jabatan</th>
                    <th>Gaji Pokok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($positions as $pos)
                    <tr>
                        <td>{{ $pos->nama_jabatan }}</td>
                        <td>Rp {{ number_format($pos->gaji_pokok, 0, ',', '.') }}</td>
                        <td>
                            <div class="action-cell">
                                <a href="{{ route('positions.show', $pos->id) }}" class="action-link-detail">Detail</a> |
                                <a href="{{ route('positions.edit', $pos->id) }}" class="action-link-edit">Edit</a> |
                                <form action="{{ route('positions.destroy', $pos->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        {{ $positions->links() }}
    @endsection
</body>

</html>
