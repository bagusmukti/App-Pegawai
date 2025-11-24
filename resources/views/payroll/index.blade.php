@extends('master')
@section('title', 'Rekap Gaji Bulanan')
@section('page-title', 'Rekap Gaji Bulanan')
@section('content')

    <h1 class="page-title">Rekap Gaji Bulanan</h1>

    <form method="GET" action="{{ auth()->user()->role === 'admin' ? route('admin.payroll.index') : route('payroll.index') }}" class="form-container" style="margin-bottom: 15px;">
        <table class="form-table">
            <tr>
                <td><label for="month">Bulan</label></td>
                <td>
                    <select id="month" name="month" class="form-input">
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="year">Tahun</label></td>
                <td>
                    <input id="year" type="number" name="year" class="form-input" value="{{ $year }}">
                </td>
            </tr>
            <tr>
                <td></td>
                <td class="form-table-actions">
                    <button class="btn btn-primary" type="submit">Terapkan</button>
                    @if(auth()->user()->role === 'admin')
                        <a class="btn btn-secondary" href="{{ route('admin.payroll.export', ['month'=>$month,'year'=>$year]) }}" target="_blank">Export PDF</a>
                    @endif
                </td>
            </tr>
        </table>
    </form>

    <table class="styled-table">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Hari Hadir</th>
                <th>Menit Terlambat</th>
                <th>Kelipatan 15 Menit</th>
                <th>Jam Lembur</th>
                <th>Potongan</th>
                <th>Tunjangan</th>
                <th>Total Gaji Bulanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payrollData as $data)
            <tr>
                <td>{{ $data['nama_lengkap'] }}</td>
                <td>{{ $data['jabatan'] }}</td>
                <td>Rp {{ number_format($data['gaji_pokok'], 0, ',', '.') }}</td>
                <td>{{ $data['hari_hadir'] }}</td>
                <td>{{ $data['menit_terlambat'] }} menit</td>
                <td>{{ $data['kelipatan_15_menit'] }} x 15 menit</td>
                <td>{{ $data['jam_lembur'] }} jam</td>
                <td>Rp {{ number_format($data['potongan'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($data['tunjangan'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($data['total_gaji_bulanan'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
