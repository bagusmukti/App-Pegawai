<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slip Gaji Karyawan</title>
</head>

<body>
    @extends('master')
    @section('title', 'Slip Gaji Pegawai')
    @section('page-title', 'Daftar Gaji')
    @section('content')

        <h1 class="page-title">Slip Gaji Karyawan</h1>

        <div class="add-button-container">
            <a href="{{ route('salaries.create') }}" class="btn btn-primary">Add Salaries</a>
        </div>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Bulan</th>
                    <th>Gaji Pokok</th>
                    {{-- <th>Tunjangan</th>
                    <th>Potongan</th>
                    <th>Total Gaji</th> --}}
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salaries as $sal)
                    <tr>
                        <td>{{ $sal->employee->nama_lengkap ?? 'N/A' }}</td>
                        <td>{{ $sal->bulan }}</td>
                        <td>{{ $sal->gaji_pokok }}</td>
                        {{-- <td>{{ $sal->tunjangan }}</td>
                        <td>{{ $sal->potongan }}</td>
                        <td>{{ $sal->total_gaji }}</td> --}}
                        <td>
                            <div class="action-cell">
                                <a href="{{ route('salaries.show', $sal->id) }}" class="action-link-detail">Detail</a> |
                                <a href="{{ route('salaries.edit', $sal->id) }}" class="action-link-edit">Edit</a> |
                                <form action="{{ route('salaries.destroy', $sal->id) }}" method="POST"
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
    @endsection
</body>

</html>
