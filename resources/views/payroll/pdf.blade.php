<h3 style="text-align:center;">Rekap Gaji Bulanan</h3>
<p>Bulan: {{ $month }} / Tahun: {{ $year }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Hari Hadir</th>
            <th>Menit Terlambat</th>
            <th>Menit Lembur</th>
            <th>Potongan</th>
            <th>Tunjangan</th>
            <th>Total Gaji Bulanan</th>
        </tr>
    </thead>
    @foreach($payrollData as $data)
    <tr>
        <td>{{ $data['nama_lengkap'] }}</td>
        <td>{{ $data['jabatan'] }}</td>
        <td>Rp {{ number_format($data['gaji_pokok'], 0, ',', '.') }}</td>
        <td>{{ $data['hari_hadir'] }}</td>
        <td>{{ $data['menit_terlambat'] }}</td>
        <td>{{ $data['menit_lembur'] }}</td>
        <td>Rp {{ number_format($data['potongan'], 0, ',', '.') }}</td>
        <td>Rp {{ number_format($data['tunjangan'], 0, ',', '.') }}</td>
        <td>Rp {{ number_format($data['total_gaji_bulanan'], 0, ',', '.') }}</td>
    </tr>
    @endforeach
</table>
