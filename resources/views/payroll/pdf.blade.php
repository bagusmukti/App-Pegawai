<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Gaji Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .period {
            margin: 10px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 8px;
        }
        th, td {
            border: 1px solid #333;
            padding: 4px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .currency {
            text-align: right;
            font-family: monospace;
        }
        .no-wrap {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>REKAP GAJI BULANAN</h2>
        <div class="period">
            Periode: {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Nama</th>
                <th width="12%">Jabatan</th>
                <th width="12%">Gaji Pokok</th>
                <th width="8%">Hadir</th>
                <th width="10%">Terlambat</th>
                <th width="8%">Lembur</th>
                <th width="12%">Potongan</th>
                <th width="12%">Tunjangan</th>
                <th width="11%">Total Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payrollData as $data)
            <tr>
                <td>{{ $data['nama_lengkap'] }}</td>
                <td>{{ $data['jabatan'] }}</td>
                <td class="currency">{{ number_format($data['gaji_pokok'], 0, ',', '.') }}</td>
                <td class="text-center">{{ $data['hari_hadir'] }}</td>
                <td class="text-center">
                    {{ $data['menit_terlambat'] }} mnt
                    @if(isset($data['kelipatan_15_menit']) && $data['kelipatan_15_menit'] > 0)
                        <br><small>({{ $data['kelipatan_15_menit'] }}x15)</small>
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($data['jam_lembur']))
                        {{ $data['jam_lembur'] }} jam
                    @else
                        {{ $data['menit_lembur'] ?? 0 }} mnt
                    @endif
                </td>
                <td class="currency">{{ number_format($data['potongan'], 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data['tunjangan'], 0, ',', '.') }}</td>
                <td class="currency"><strong>{{ number_format($data['total_gaji_bulanan'], 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f5f5f5; font-weight: bold;">
                <td colspan="2" class="text-center">TOTAL</td>
                <td class="currency">{{ number_format(array_sum(array_column($payrollData, 'gaji_pokok')), 0, ',', '.') }}</td>
                <td class="text-center">{{ array_sum(array_column($payrollData, 'hari_hadir')) }}</td>
                <td class="text-center">{{ array_sum(array_column($payrollData, 'menit_terlambat')) }} mnt</td>
                <td class="text-center">
                    @if(isset($payrollData[0]['jam_lembur']))
                        {{ array_sum(array_column($payrollData, 'jam_lembur')) }} jam
                    @else
                        {{ array_sum(array_column($payrollData, 'menit_lembur')) ?? 0 }} mnt
                    @endif
                </td>
                <td class="currency">{{ number_format(array_sum(array_column($payrollData, 'potongan')), 0, ',', '.') }}</td>
                <td class="currency">{{ number_format(array_sum(array_column($payrollData, 'tunjangan')), 0, ',', '.') }}</td>
                <td class="currency"><strong>{{ number_format(array_sum(array_column($payrollData, 'total_gaji_bulanan')), 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px; font-size: 9px;">
        <p><strong>Keterangan:</strong></p>
        <ul style="margin: 5px 0; padding-left: 20px;">
            <li>Potongan keterlambatan: Rp 50.000 per kelipatan 15 menit</li>
            <li>Tunjangan lembur: 5% dari gaji pokok per jam</li>
            <li>Jam kerja: 09:00 - 15:00 WIB</li>
        </ul>
        <p style="margin-top: 20px; text-align: right;">
            Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB
        </p>
    </div>
</body>
</html>
