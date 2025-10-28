<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai</title>
</head>

<body>
    @extends('master')
    @section('title', 'Daftar Pegawai')
    @section('page-title', 'Daftar Pegawai')
    @section('content')

        <h1 class="page-title">Daftar Pegawai</h1>
        <div class="add-button-container">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
        </div>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Tanggal Masuk</th>
                    <th>Departemen</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->nama_lengkap }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->nomor_telepon }}</td>
                        <td>{{ $employee->tanggal_lahir }}</td>
                        <td>{{ $employee->alamat }}</td>
                        <td>{{ $employee->tanggal_masuk }}</td>
                        <td>{{ $employee->department->nama_departemen ?? 'N/A' }}</td>
                        <td>{{ $employee->position->nama_jabatan ?? 'N/A' }}</td>
                        <td>{{ $employee->status }}</td>
                        <td>
                            <div class="action-cell">
                                <a href="{{ route('employees.show', $employee->id) }}" class="action-link-detail">Detail</a> |
                                <a href="{{ route('employees.edit', $employee->id) }}" class="action-link-edit">Edit</a> |
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
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
