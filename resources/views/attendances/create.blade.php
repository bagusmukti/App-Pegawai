<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Input Attendance Pegawai</title>
</head>
<body>
    <h1>Form Attendance</h1>
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        <table>
            <tr>
                <td><label for="karyawan_id">Nama Karyawan:</label></td>
                <td>
                    <select name="karyawan_id" id="karyawan_id" required>
                        <option value="">Pilih Karyawan</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="tanggal">Tanggal : </label></td>
                <td><input type="date" id="tanggal" name="tanggal" required></td>
            </tr>
             <tr>
                <td><label for="waktu_masuk">Waktu Masuk:</label></td>
                <td><input type="time" id="waktu_masuk" name="waktu_masuk"></td>
            </tr>
            <tr>
                <td><label for="waktu_keluar">Waktu Keluar:</label></td>
                <td><input type="time" id="waktu_keluar" name="waktu_keluar"></td>
            </tr>
            <tr>
                <td><label for="status_absensi">Status Absensi : </label></td>
                <select name="status_absensi" id="status_absensi" required>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right;">
                    <button type="submit">Simpan</button>
                </td>    
            </tr>            
        </table>
    </form>
</body>
</html>