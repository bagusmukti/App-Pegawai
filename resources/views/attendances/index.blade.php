@extends('master')
    @section('title', 'Daftar Kehadiran Pegawai')
    @section('page-title', 'Daftar Presensi')
    @section('content')

        <h1 class="page-title">Daftar Kehadiran Karyawan</h1>
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">Add Attendance</a>
    <a href="{{ route('admin.attendance.check') }}" class="btn btn-secondary">Check Attendance (Hari Ini)</a>
    @else
    <a href="{{ route('attendance.check') }}" class="btn btn-secondary">Check Attendance (Hari Ini)</a>
    @endif
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Tanggal</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Status Kehadiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendance as $attemployee)
                    <tr>
                        <td>{{ $attemployee->employee->nama_lengkap ?? 'N/A' }}</td>
                        <td>{{ $attemployee->tanggal }}</td>
                        <td>{{ $attemployee->waktu_masuk ?? '-' }}</td>
                        <td>{{ $attemployee->waktu_keluar ?? '-' }}</td>
                        <td>{{ $attemployee->status_absensi }}</td>
                        <td>
                            <div class="action-cell">
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.attendance.show', $attemployee->id) }}"
                                    class="action-link-detail">Detail</a> |
                                <a href="{{ route('admin.attendance.edit', $attemployee->id) }}" class="action-link-edit">Edit</a>
                                |
                                <form action="{{ route('admin.attendance.destroy', $attemployee->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                </form>
                                @else
                                {{-- Employee hanya bisa lihat detail, tidak bisa edit/delete --}}
                                <span class="badge badge-info">View Only</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        {{ $attendance->links() }}
    @endsection
