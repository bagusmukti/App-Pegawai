<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Input Gaji</title>
</head>

<body>
    @extends('master')
    @section('title', 'Form Input Gaji Pegawai')
    @section('page-title', 'Input Gaji')
    @section('content')

        <h1 class="form-title">Form Input Gaji</h1>

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form-container" action="{{ route('salaries.store') }}" method="POST">
            @csrf
            <table class="form-table">
                <tr>
                    <td><label for="karyawan_id">Nama Karyawan:</label></td>
                    <td>
                        <select name="karyawan_id" id="karyawan_id" class="form-input" required>
                            <option value="">Pilih Karyawan</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" data-gaji="{{ $employee->position->gaji_pokok ?? 0 }}">
                                    {{ $employee->nama_lengkap }} ({{ $employee->position->nama_jabatan ?? '-' }})</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="bulan">Bulan:</label></td>
                    <td><input type="text" id="bulan" name="bulan" class="form-input"></td>
                </tr>
                <tr>
                    <td><label for="gaji_pokok">Gaji Pokok:</label></td>
                    <td><input type="text" id="gaji_pokok" name="gaji_pokok" class="form-input" readonly></td>
                </tr>
                <tr>
                    <td><label for="tunjangan">Tunjangan:</label></td>
                    <td><input type="text" id="tunjangan" name="tunjangan" class="form-input"></td>
                </tr>
                <tr>
                    <td><label for="potongan">Potongan:</label></td>
                    <td><input type="text" id="potongan" name="potongan" class="form-input"></td>
                </tr>
                <tr>
                    <td><label for="total_gaji">Total Gaji:</label></td>
                    <td>
                        <textarea id="total_gaji" name="total_gaji" class="form-input"></textarea>
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
        <script>
            // 1. Definisikan elemen-elemen form yang kita perlukan
            const karyawanSelect = document.getElementById('karyawan_id');
            const gajiPokokInput = document.getElementById('gaji_pokok');
            const tunjanganInput = document.getElementById('tunjangan');
            const potonganInput = document.getElementById('potongan');
            const totalGajiOutput = document.getElementById('total_gaji'); // Ini adalah textarea

            // 2. Buat fungsi untuk menghitung total gaji
            function calculateTotal() {
                // Ambil nilai dari input, ubah ke angka (parseFloat).
                // '|| 0' digunakan untuk memberi nilai default 0 jika input kosong atau tidak valid
                const pokok = parseFloat(gajiPokokInput.value) || 0;
                const tunjangan = parseFloat(tunjanganInput.value) || 0;
                const potongan = parseFloat(potonganInput.value) || 0;

                const total = (pokok + tunjangan) - potongan;

                // Tampilkan hasilnya di textarea 'total_gaji'
                totalGajiOutput.value = total;
            }

            // 3. Tambahkan "event listener" untuk dropdown karyawan
            karyawanSelect.addEventListener('change', function() {
                // 'this' merujuk ke elemen 'karyawanSelect'
                // 'this.selectedIndex' adalah urutan option yang dipilih
                // 'this.options[...]' adalah elemen <option> yang dipilih
                const selectedOption = this.options[this.selectedIndex];

                // Ambil nilai 'data-gaji' dari option yang dipilih
                const gajiPokok = selectedOption.dataset.gaji;

                // Set nilai input 'gaji_pokok'
                gajiPokokInput.value = gajiPokok;

                // Setelah gaji pokok terisi, panggil fungsi kalkulasi
                calculateTotal();
            });

            // 4. Tambahkan "event listener" untuk input tunjangan dan potongan
            // Kita pakai event 'input' agar kalkulasi berjalan setiap kali ada ketikan
            tunjanganInput.addEventListener('input', calculateTotal);
            potonganInput.addEventListener('input', calculateTotal);
        </script>
    @endsection
</body>

</html>
