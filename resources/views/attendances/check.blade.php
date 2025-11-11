@extends('master')

@section('content')
<div class="container mt-4">
    <h1>Cek Kehadiran Hari Ini</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('attendance.check') }}" class="mb-3">
        <label for="karyawan_id">Pilih Karyawan:</label>
        <select name="karyawan_id" id="karyawan_id" onchange="this.form.submit()">
            <option value="">-- pilih --</option>
            @foreach($employees as $emp)
                <option value="{{ $emp->id }}" {{ $employeeId == $emp->id ? 'selected' : '' }}>{{ $emp->nama_lengkap }}</option>
            @endforeach
        </select>
    </form>

    @if(!$employeeId)
        <p>Silakan pilih karyawan untuk melihat status absensi hari ini.</p>
    @elseif(!$todayAttendance)
        <div class="card">
            <div class="card-body">
                <p>Belum ada data absensi untuk hari ini.</p>
                <form method="POST" action="{{ route('attendance.masuk') }}">
                    @csrf
                    <input type="hidden" name="karyawan_id" value="{{ $employeeId }}">
                    <button type="submit" class="btn btn-primary">Absen Masuk</button>
                </form>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($todayAttendance->tanggal)->format('d-m-Y') }}</p>
                <p><strong>Waktu Masuk:</strong> {{ $todayAttendance->waktu_masuk ?? '-' }}</p>
                <p><strong>Waktu Keluar:</strong> {{ $todayAttendance->waktu_keluar ?? '-' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($todayAttendance->status_absensi) }}</p>

                @if(!$todayAttendance->waktu_keluar)
                    <form method="POST" action="{{ route('attendance.keluar') }}">
                        @csrf
                        <input type="hidden" name="karyawan_id" value="{{ $employeeId }}">
                        <button type="submit" class="btn btn-success">Absen Keluar</button>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
