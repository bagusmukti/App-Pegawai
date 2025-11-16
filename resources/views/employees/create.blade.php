<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Pegawai</title>
</head>

<body>
    @extends('master')
    @section('title', 'Form Daftar Pegawai')
    @section('page-title', 'Add Pegawai')
    @section('content')

        <h1 class="form-title">Form Pegawai</h1>
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form-container" action="{{ route('employees.store') }}" method="POST">
            @csrf
            <table class="form-table">
                <tr>
                    <td><label for="nama_lengkap">Nama Lengkap:</label></td>
                    <td><input type="text" id="nama_lengkap" name="nama_lengkap" class="form-input" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" class="form-input" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password" class="form-input" required></td>
                </tr>
                <tr>
                    <td><label for="nomor_telepon">Nomor Telepon:</label></td>
                    <td><input type="text" id="nomor_telepon" name="nomor_telepon" class="form-input" required></td>
                </tr>
                <tr>
                    <td><label for="tanggal_lahir">Tanggal Lahir:</label></td>
                    <td><input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" required></td>
                </tr>
                <tr>
                    <td><label for="alamat">Alamat:</label></td>
                    <td>
                        <textarea id="alamat" name="alamat" class="form-input" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td><label for="tanggal_masuk">Tanggal Masuk:</label></td>
                    <td><input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-input" required></td>
                </tr>
                <tr>
                    <td><label for="departemen_id">Departemen:</label></td>
                    <td><select name="departemen_id" id="departemen_id" class="form-input" required>
                            <option value="">Pilih Departemen</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">
                                    {{ $dept->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                        @error('departemen_id')
                            <span style="color:red;">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="jabatan_id">Jabatan:</label></td>
                    <td><select name="jabatan_id" id="jabatan_id" class="form-input" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach ($positions as $pos)
                                <option value="{{ $pos->id }}">
                                    {{ $pos->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('jabatan_id')
                            <span style="color:red;">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td><label for="status">Status:</label></td>
                    <td>
                        <select id="status" name="status" class="form-input">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="form-table-actions" style="text-align: center; margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    @endsection
</body>

</html>
