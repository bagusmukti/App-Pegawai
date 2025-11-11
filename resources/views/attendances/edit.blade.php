@extends('master')
    @section('title', 'Form Edit Kehadiran Pegawai')
    @section('page-title', 'Edit Absensi')
    @section('content')

        <h2 class="form-title">Edit data Pegawai</h2>
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form-container" action="{{ route('attendance.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="form-table">
                <tr>
                    <td>Nama Lengkap</td>
                    <td>
                        <select name="karyawan_id" id="karyawan_id" class="form-input" required>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('karyawan_id', $attendance->karyawan_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td><input type="date" name="tanggal" class="form-input"
                            value="{{ old('tanggal', $attendance->tanggal) }}"></td>
                </tr>
                <tr>
                    <td>Waktu Masuk</td>
                    <td><input type="time" name="waktu_masuk" class="form-input"
                            value="{{ old('waktu_masuk', $attendance->waktu_masuk) }}"></td>
                </tr>
                <tr>
                    <td>Waktu Keluar</td>
                    <td><input type="time" name="waktu_keluar" class="form-input"
                            value="{{ old('waktu_keluar', $attendance->waktu_keluar) }}"></td>
                </tr>
                <tr>
                    <td>Status Absensi</td>
                    <td>
                        <select name="status_absensi" class="form-input">
                            <option value="hadir"
                                {{ old('status_absensi', $attendance->status_absensi) == 'hadir' ? 'selected' : '' }}>Hadir
                            </option>
                            <option value="izin"
                                {{ old('status_absensi', $attendance->status_absensi) == 'izin' ? 'selected' : '' }}>Izin
                            </option>
                            <option value="sakit"
                                {{ old('status_absensi', $attendance->status_absensi) == 'sakit' ? 'selected' : '' }}>Sakit
                            </option>
                            <option value="alpha"
                                {{ old('status_absensi', $attendance->status_absensi) == 'alpha' ? 'selected' : '' }}>Alpha
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="form-table-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </td>
                </tr>
            </table>
        </form>
    @endsection
