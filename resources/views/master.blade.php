<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','App Pegawai')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
        <header>
            <h1>@yield('page-title', 'App Pegawai')</h1>
        </header>
        <nav>
            <ul>
                <li><a href="{{ url('/employees') }}">Employee</a></li>
                <li><a href="{{ url('/departments') }}">Department</a></li>
                <li><a href="{{ url('/attendance') }}">Attendance List</a></li>
                <li><a href="{{ route('attendance.check') }}">Attendance Check</a></li>
                <li><a href="{{ url('/salaries') }}">Salaries</a></li>
                <li><a href="{{ route('payroll.index') }}">Payroll</a></li>
                <li><a href="{{ url('/positions') }}">Positions</a></li>
                <li><a href="{{ url('/payroll') }}">Payroll</a></li>
                <li><a href="{{ url('/report') }}">Report</a></li>
                <li><a href="{{ url('/settings') }}">Settings</a></li>
            </ul>
        </nav>
    </div>
    <section>
         <main>
            @yield('content')
         </main>
        <footer>
            <p>&copy; {{ date('Y') }} App Pegawai</p>
        </footer>
    </section>
</body>
</html>