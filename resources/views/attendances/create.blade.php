@extends('master')
    @section('title', 'Form Kehadiran Pegawai')
    @section('page-title', 'Tambah Absensi')
    @section('content')

        <h1 class="form-title">Form Attendance</h1>
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form-container" action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <table class="form-table">
                <tr>
                    <td><label for="karyawan_id">Nama Karyawan:</label></td>
                    <td>
                        <select name="karyawan_id" id="karyawan_id" class="form-input" required>
                            <option value="">Pilih Karyawan</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="tanggal">Tanggal : </label></td>
                    <td><input type="date" id="tanggal" name="tanggal" class="form-input" required></td>
                </tr>
                <tr>
                    <td><label for="waktu_masuk">Waktu Masuk:</label></td>
                    <td><input type="time" id="waktu_masuk" name="waktu_masuk" class="form-input"></td>
                </tr>
                <tr>
                    <td><label for="waktu_keluar">Waktu Keluar:</label></td>
                    <td><input type="time" id="waktu_keluar" name="waktu_keluar" class="form-input"></td>
                </tr>
                <tr>
                    <td><label for="status_absensi">Status Absensi : </label></td>
                    <td>
                        <select name="status_absensi" id="status_absensi" class="form-input" required>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="form-table-actions">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </td>
                </tr>
            </table>
        </form>
    @endsection
