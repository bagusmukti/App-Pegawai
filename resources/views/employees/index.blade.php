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
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="add-button-container">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
        </div>
        
        <div class="table-responsive">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th style="min-width: 50px;">No</th>
                        <th style="min-width: 150px;">Nama Lengkap</th>
                        <th style="min-width: 180px;">Email</th>
                        <th style="min-width: 120px;">Password</th>
                        <th style="min-width: 120px;">No. Telepon</th>
                        <th style="min-width: 120px;">Tanggal Lahir</th>
                        <th style="min-width: 200px;">Alamat</th>
                        <th style="min-width: 120px;">Tanggal Masuk</th>
                        <th style="min-width: 120px;">Departemen</th>
                        <th style="min-width: 120px;">Jabatan</th>
                        <th style="min-width: 100px;">Status</th>
                        <th style="min-width: 80px;">Role</th>
                        <th style="min-width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $index => $employee)
                        <tr>
                            <td>{{ $employees->firstItem() + $index }}</td>
                            <td>{{ $employee->nama_lengkap }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->password }}</td>
                            <td>{{ $employee->nomor_telepon }}</td>
                            <td>{{ \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d-m-Y') }}</td>
                            <td>{{ $employee->alamat }}</td>
                            <td>{{ \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d-m-Y') }}</td>
                            <td>{{ $employee->department->nama_departemen ?? 'N/A' }}</td>
                            <td>{{ $employee->position->nama_jabatan ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-{{ $employee->status === 'aktif' ? 'success' : 'danger' }}">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    {{ ucfirst($employee->role ?? 'employee') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-cell">
                                    <a href="{{ route('employees.show', $employee->id) }}" class="action-link-detail">Detail</a>
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="action-link-edit">Edit</a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container" style="margin-top: 20px;">
            {{ $employees->links() }}
        </div>
    @endsection
</body>

</html>
