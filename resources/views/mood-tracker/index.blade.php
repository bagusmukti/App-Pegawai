@extends('master')
@section('page-title', 'Mood Pegawai')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if(Auth::user()->role === 'admin')
                <h2><i class="fas fa-chart-line"></i> Employee Mood Analytics</h2>
            @else
                <h2><i class="fas fa-smile"></i> Employee Mood Tracker</h2>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        @if(Auth::user()->role === 'admin')
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['avg_mood_today'] ? number_format($stats['avg_mood_today'], 1) : 'N/A' }}</h3>
                        <p class="mb-0">Today's Average</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['avg_mood_week'] ? number_format($stats['avg_mood_week'], 1) : 'N/A' }}</h3>
                        <p class="mb-0">This Week</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['avg_mood_month'] ? number_format($stats['avg_mood_month'], 1) : 'N/A' }}</h3>
                        <p class="mb-0">This Month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['total_entries_today'] }}/{{ $stats['total_employees'] }}</h3>
                        <p class="mb-0">Entries Today</p>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['today_mood'] ? $stats['today_mood']->mood_emoji : '😐' }}</h3>
                        <p class="mb-0">Today's Mood</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['avg_mood_week'] ? number_format($stats['avg_mood_week'], 1) : 'N/A' }}</h3>
                        <p class="mb-0">Week Average</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['avg_mood_month'] ? number_format($stats['avg_mood_month'], 1) : 'N/A' }}</h3>
                        <p class="mb-0">Month Average</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3>{{ $stats['streak_days'] }}</h3>
                        <p class="mb-0">Day Streak</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            @if(Auth::user()->role === 'employee')
                @if(!$stats['today_mood'])
                    <a href="{{ route('mood-tracker.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus"></i> Record Today's Mood
                    </a>
                @else
                    <a href="{{ route('mood-tracker.edit', $stats['today_mood']->id) }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-edit"></i> Update Mood Hari Ini
                    </a>
                @endif
            @endif
            
            <!-- Period Filter -->
            <div class="float-right">
                <div class="btn-group" role="group">
                    <a href="{{ request()->fullUrlWithQuery(['period' => 'today']) }}" 
                       class="btn btn-outline-primary {{ $period === 'today' ? 'active' : '' }}">Today</a>
                    <a href="{{ request()->fullUrlWithQuery(['period' => 'week']) }}" 
                       class="btn btn-outline-primary {{ $period === 'week' ? 'active' : '' }}">This Week</a>
                    <a href="{{ request()->fullUrlWithQuery(['period' => 'month']) }}" 
                       class="btn btn-outline-primary {{ $period === 'month' ? 'active' : '' }}">This Month</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mood Entries Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        @if(Auth::user()->role === 'admin')
                            <i class="fas fa-table"></i> Team Mood Entries
                        @else
                            <i class="fas fa-history"></i> My Mood History
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if($moods->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        @if(Auth::user()->role === 'admin')
                                            <th>Employee</th>
                                        @endif
                                        <th>Date</th>
                                        <th>Mood</th>
                                        <th>Weather</th>
                                        <th>Workload</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($moods as $mood)
                                        <tr>
                                            @if(Auth::user()->role === 'admin')
                                                <td>
                                                    @if($mood->employee)
                                                        <div><strong>{{ $mood->employee->nama_lengkap }}</strong></div>
                                                        <div class="text-muted small">
                                                            {{ $mood->employee->position->nama_jabatan ?? 'No Position' }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            {{ $mood->employee->department->nama_departemen ?? 'No Department' }}
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                <strong>{{ $mood->mood_date->format('D, d M Y') }}</strong><br>
                                            </td>
                                            <td>
                                                <span class="badge badge-pill mood-{{ $mood->mood_level }} p-2">
                                                    {{ $mood->mood_emoji }} {{ $mood->mood_label }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($mood->weather_impact)
                                                    {{ $mood->weather_icon }} {{ ucfirst($mood->weather_impact) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($mood->workload_level)
                                                    <div class="workload-indicator">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <span class="workload-dot {{ $i <= $mood->workload_level ? 'active' : '' }}">●</span>
                                                        @endfor
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($mood->notes)
                                                    <span data-toggle="tooltip" title="{{ $mood->notes }}">
                                                        {{ Str::limit($mood->notes, 30) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.mood-tracker.show' : 'mood-tracker.show', $mood->id) }}" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if(Auth::user()->role === 'employee' && $mood->mood_date->isToday())
                                                    <a href="{{ route('mood-tracker.edit', $mood->id) }}" 
                                                       class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                
                                                @if(Auth::user()->role === 'admin')
                                                    <form action="{{ route('admin.mood-tracker.destroy', $mood->id) }}" 
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this mood entry?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $moods->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No mood entries found</h5>
                            @if(Auth::user()->role === 'employee')
                                <p class="text-muted">Start tracking your daily wellness!</p>
                                <a href="{{ route('mood-tracker.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Record Your First Mood
                                </a>
                            @else
                                <p class="text-muted">No employee mood data for the selected period.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.mood-1 { background-color: #dc3545; color: white; }
.mood-2 { background-color: #fd7e14; color: white; }
.mood-3 { background-color: #ffc107; color: black; }
.mood-4 { background-color: #20c997; color: white; }
.mood-5 { background-color: #28a745; color: white; }

.workload-indicator {
    font-size: 12px;
    letter-spacing: 2px;
}

.workload-dot {
    color: #dee2e6;
}

.workload-dot.active {
    color: #007bff;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.btn-group .btn.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}
</style>

<script>
// Initialize tooltips
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection