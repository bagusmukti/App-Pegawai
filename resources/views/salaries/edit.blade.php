<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Slip Gaji</title>
</head>

<body>
    @extends('master')
    @section('title', 'Form Edit Gaji Pegawai')
    @section('page-title', 'Edit Slip Gaji')
    @section('content')

        <h2 class="form-title">Edit Data Slip Gaji</h2>

        <form class="form-container" action="{{ route('salaries.update', $salaries->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="form-table">
                <tr>
                    <td>Nama Karyawan</td>
                    <td>
                        <select name="karyawan_id" id="karyawan_id" class="form-input" required>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" data-gaji="{{ $employee->position->gaji_pokok ?? 0 }}"
                                    {{ old('karyawan_id', $salaries->karyawan_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->nama_lengkap }} ({{ $employee->position->nama_jabatan ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Bulan</td>
                    <td><input type="text" name="bulan" class="form-input"
                            value="{{ old('bulan', $salaries->bulan) }}"></td>
                </tr>
                <tr>
                    <td>Gaji Pokok</td>
                    <td><input type="text" name="gaji_pokok" id="gaji_pokok" class="form-input" 
                            value="{{ old('gaji_pokok', $salaries->gaji_pokok) }}"></td>
                </tr>
                {{-- <tr>
                    <td>Tunjangan</td>
                    <td><input type="text" name="tunjangan" id="tunjangan" class="form-input"
                            value="{{ old('tunjangan', $salaries->tunjangan) }}"></td>
                </tr>
                <tr>
                    <td>Potongan</td>
                    <td><input type="text" name="potongan" id="potongan" class="form-input"
                            value="{{ old('potongan', $salaries->potongan) }}"></td>
                </tr>
                <tr>
                    <td>Total Gaji</td>
                    <td><input type="text" name="total_gaji" id="total_gaji" class="form-input"
                            value="{{ old('total_gaji', $salaries->total_gaji) }}"></td>
                </tr> --}}
                <tr>
                    <td></td>
                    <td class="form-table-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </td>
                </tr>
                 <div class="detail-actions">
                    <a href="{{ route('salaries.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                </div>
            </table>
        </form>
        {{-- <script>
            const karyawanSelect = document.getElementById('karyawan_id');
            const gajiPokokInput = document.getElementById('gaji_pokok');
            const tunjanganInput = document.getElementById('tunjangan');
            const potonganInput = document.getElementById('potongan');
            const totalGajiOutput = document.getElementById('total_gaji');

            function calculateTotal() {
                const pokok = parseFloat(gajiPokokInput.value) || 0;
                const tunjangan = parseFloat(tunjanganInput.value) || 0;
                const potongan = parseFloat(potonganInput.value) || 0;

                totalGajiOutput.value = (pokok + tunjangan) - potongan;
            }

            tunjanganInput.addEventListener('input', calculateTotal);
            potonganInput.addEventListener('input', calculateTotal);
        </script> --}}
    @endsection
</body>

</html>
