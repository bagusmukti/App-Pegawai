<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pegawai</title>
</head>
<body>
    @extends('master')
    @section('title', 'Form Edit Pegawai')
    @section('page-title', 'Edit Pegawai')
    @section('content')

    <h2 class="form-title">Edit Data Pegawai</h2>
    <form class="form-container" action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')
        <table class="form-table">
            <tr>
                <td>Nama Lengkap</td>
                <td><input type="text" name="nama_lengkap" class="form-input" value="{{ old('nama_lengkap', $employee->nama_lengkap) }}"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name="email" class="form-input" value="{{ old('email', $employee->email) }}"></td>
            </tr>
             <tr>
                <td>Password</td>
                <td><input type="password" name="password" class="form-input" value="{{ old('password', $employee->password) }}"></td>
            </tr>
            <tr>
                <td>Nomor Telepon</td>
                <td><input type="text" name="nomor_telepon" class="form-input" value="{{ old('nomor_telepon', $employee->nomor_telepon) }}"></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td><input type="date" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir', $employee->tanggal_lahir) }}"></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><input type="text" name="alamat" class="form-input" value="{{ old('alamat', $employee->alamat) }}"></td>
            </tr>
           <tr>
                <td>Tanggal Masuk</td>
                <td><input type="date" name="tanggal_masuk" class="form-input" value="{{ old('tanggal_masuk', $employee->tanggal_masuk) }}"></td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>
                <select name="departemen_id" id="departemen_id" class="form-input" required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('departemen_id', $employee->departemen_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->nama_departemen }}
                        </option>
                    @endforeach
                </select>
            </td>
            </tr>
                <tr>
                <td>Jabatan</td>
                <td>
                <select name="jabatan_id" id="jabatan_id" class="form-input" required>
                    @foreach($positions as $pos)
                        <option value="{{ $pos->id }}" {{ old('jabatan_id', $employee->jabatan_id) == $pos->id ? 'selected' : '' }}>
                            {{ $pos->nama_jabatan }}
                        </option>
                    @endforeach
                </select>
            </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <select name="status" class="form-input">
                    <option value="aktif" {{ old('status', $employee->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak aktif" {{ old('status', $employee->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </td>
            </tr>
             <tr>
                <td>Role</td>
                <td>
                    <select name="role" class="form-input">
                    <option value="employee" {{ old('role', $employee->role) == 'employee' ? 'selected' : '' }}>Employee</option>
                    </select>
                </td>
            </tr>
        </table>
            <tr>
                <td></td>
                <td class="form-table-actions">
                    <button type="submit" class="btn btn-primary">Update</button>
                </td>
            </tr>
             <div class="form-actions" style="text-align: left; max-width: 700px;">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
    </form>
    @endsection
</body>
</html>