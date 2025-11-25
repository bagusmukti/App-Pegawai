@extends('master')

@section('page-title', 'Presensi')
@section('content')
<div class="container mt-4">
    <h1 class="page-title">Cek Kehadiran Hari Ini</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(auth()->user()->role === 'admin')
    {{-- Hanya admin yang bisa pilih karyawan --}}
    <form method="GET" action="{{ route('admin.attendance.check') }}" class="mb-3" style="margin-bottom: 20px;">
        <table class="form-table">
            <tr>
                <td><label for="karyawan_id">Pilih Karyawan:</label></td>
                <td>
                    <select name="karyawan_id" id="karyawan_id" class="form-input" onchange="this.form.submit()">
                        <option value="">-- pilih --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ $employeeId == $emp->id ? 'selected' : '' }}>{{ $emp->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </table>
    </form>
    @else
    {{-- Employee otomatis sudah ter-select, tampilkan nama saja --}}
    @if($employeeId)
        @php
            $currentEmployee = $employees->firstWhere('id', $employeeId);
        @endphp
        <div class="card" style="background: #e3f2fd; padding: 15px; border-radius: 8px; border: 1px solid #2196F3; margin-bottom: 20px;">
            <p style="margin: 0; color: #1976D2; font-weight: bold;">
                <i class="fas fa-user"></i> Absensi untuk: {{ $currentEmployee->nama_lengkap ?? 'Unknown' }}
            </p>
        </div>
    @endif
    @endif

    @if(!$employeeId)
        <p>Silakan pilih karyawan untuk melihat status absensi hari ini.</p>
    @elseif(!$todayAttendance)
        <div class="card" style="background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
            <div class="card-body">
                <p>Belum ada data absensi untuk hari ini.</p>
                <form method="POST" action="{{ auth()->user()->role === 'admin' ? route('admin.attendance.masuk') : route('attendance.masuk') }}">
                    @csrf
                    <input type="hidden" name="karyawan_id" value="{{ $employeeId }}">
                    <button type="submit" class="btn btn-primary">Absen Masuk</button>
                </form>
            </div>
        </div>
    @else
        <div class="card" style="background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
            <div class="card-body">
                <table class="detail-table">
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ \Carbon\Carbon::parse($todayAttendance->tanggal)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Masuk</th>
                        <td>{{ $todayAttendance->waktu_masuk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Keluar</th>
                        <td>{{ $todayAttendance->waktu_keluar ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="badge badge-success">{{ ucfirst($todayAttendance->status_absensi) }}</span></td>
                    </tr>
                </table>

                @if(!$todayAttendance->waktu_keluar)
                    <form method="POST" action="{{ auth()->user()->role === 'admin' ? route('admin.attendance.keluar') : route('attendance.keluar') }}" style="margin-top: 15px;">
                        @csrf
                        <input type="hidden" name="karyawan_id" value="{{ $employeeId }}">
                        <button type="submit" class="btn btn-primary">Absen Keluar</button>
                    </form>
                @endif
            </div>
        </div>
    @endif
    <div class="detail-actions">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.attendance.index') : route('attendance.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
</div>
@endsection
