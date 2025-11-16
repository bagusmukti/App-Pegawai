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
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('employees.index') }}"><i class="fas fa-users"></i> Employee</a></li>
                        <li><a href="{{ route('departments.index') }}"><i class="fas fa-building"></i> Department</a></li>
                        <li><a href="{{ route('positions.index') }}"><i class="fas fa-briefcase"></i> Positions</a></li>
                        <li><a href="{{ route('admin.attendance.index') }}"><i class="fas fa-clipboard-list"></i> Attendance List</a></li>
                        <li><a href="{{ route('admin.attendance.check') }}"><i class="fas fa-check-circle"></i> Attendance Check</a></li>
                        <li><a href="{{ route('salaries.index') }}"><i class="fas fa-money-bill-wave"></i> Salaries</a></li>
                        <li><a href="{{ route('admin.payroll.index') }}"><i class="fas fa-file-invoice-dollar"></i> Payroll</a></li>
                    @else
                        <li><a href="{{ route('attendance.check') }}"><i class="fas fa-check-circle"></i> Attendance Check</a></li>
                        <li><a href="{{ route('attendance.index') }}"><i class="fas fa-clipboard-list"></i> My Attendance</a></li>
                        <li><a href="{{ route('payroll.index') }}"><i class="fas fa-file-invoice-dollar"></i> My Payroll</a></li>
                    @endif
                @endauth
            </ul>
        </nav>
        
        <!-- User Profile & Logout Section -->
        @auth
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <div>
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">
                            <i class="fas fa-shield-alt"></i> {{ ucfirst(auth()->user()->role) }}
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="btn btn-danger" onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) window.location.href='{{ route('logout') }}';">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
        @endauth
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