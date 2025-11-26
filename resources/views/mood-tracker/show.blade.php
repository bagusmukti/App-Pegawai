@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-eye"></i> Mood Entry Details</h2>
            <p class="text-muted">
                @if(Auth::user()->role === 'admin')
                    Employee wellness information
                @else
                    Your mood entry details
                @endif
            </p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Main Mood Card -->
            <div class="card mood-detail-card">
                <div class="card-header text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-day"></i> 
                        {{ $mood->mood_date->format('l, F d, Y') }}
                    </h4>
                    <small class="text-light">{{ $mood->mood_date->diffForHumans() }}</small>
                </div>
                <div class="card-body">
                    <!-- Employee Info (for admin) -->
                    @if(Auth::user()->role === 'admin')
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="employee-info">
                                    <h5><i class="fas fa-user"></i> Employee Information</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Name:</strong> {{ $mood->employee->nama_lengkap }}</p>
                                            <p><strong>Position:</strong> {{ $mood->employee->position->name ?? 'No Position' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Department:</strong> {{ $mood->employee->department->name ?? 'No Department' }}</p>
                                            <p><strong>Email:</strong> {{ $mood->employee->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    @endif

                    <!-- Mood Information -->
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mood-display">
                                <div class="mood-emoji-large">{{ $mood->mood_emoji }}</div>
                                <h5 class="mood-level-badge">
                                    <span class="badge badge-pill mood-{{ $mood->mood_level }} p-3">
                                        {{ $mood->mood_label }}
                                    </span>
                                </h5>
                                <p class="text-muted">Mood Level: {{ $mood->mood_level }}/5</p>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="mood-details">
                                <!-- Weather Impact -->
                                <div class="detail-item">
                                    <h6><i class="fas fa-cloud-sun"></i> Weather Impact</h6>
                                    @if($mood->weather_impact)
                                        <p class="weather-display">
                                            {{ $mood->weather_icon }} 
                                            <strong>{{ ucfirst($mood->weather_impact) }}</strong>
                                            @switch($mood->weather_impact)
                                                @case('sunny')
                                                    - Energizing and uplifting
                                                    @break
                                                @case('cloudy')
                                                    - Calm and neutral
                                                    @break
                                                @case('rainy')
                                                    - Cozy or gloomy feelings
                                                    @break
                                                @case('hot')
                                                    - Exhausting or draining
                                                    @break
                                                @case('cold')
                                                    - Refreshing and crisp
                                                    @break
                                            @endswitch
                                        </p>
                                    @else
                                        <p class="text-muted">No weather impact recorded</p>
                                    @endif
                                </div>

                                <!-- Workload Level -->
                                <div class="detail-item">
                                    <h6><i class="fas fa-tasks"></i> Workload Level</h6>
                                    @if($mood->workload_level)
                                        <div class="workload-display">
                                            <div class="workload-indicator">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="workload-dot {{ $i <= $mood->workload_level ? 'active' : '' }}">●</span>
                                                @endfor
                                            </div>
                                            <p class="workload-description">
                                                <strong>
                                                    @switch($mood->workload_level)
                                                        @case(1) Very Light @break
                                                        @case(2) Light @break
                                                        @case(3) Moderate @break
                                                        @case(4) Heavy @break
                                                        @case(5) Very Heavy @break
                                                    @endswitch
                                                </strong>
                                                ({{ $mood->workload_level }}/5)
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-muted">No workload level recorded</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    @if($mood->notes)
                        <hr>
                        <div class="notes-section">
                            <h6><i class="fas fa-sticky-note"></i> Additional Notes</h6>
                            <div class="notes-content">
                                <blockquote class="blockquote">
                                    <p class="mb-0">{{ $mood->notes }}</p>
                                </blockquote>
                            </div>
                        </div>
                    @endif

                    <!-- Timestamps -->
                    <hr>
                    <div class="timestamps">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">
                                    <i class="fas fa-clock"></i> <strong>Submitted:</strong>
                                </p>
                                <p>{{ $mood->created_at->format('d M Y, H:i:s') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">
                                    <i class="fas fa-edit"></i> <strong>Last Updated:</strong>
                                </p>
                                <p>{{ $mood->updated_at->format('d M Y, H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card mt-3">
                <div class="card-body text-center">
                    @if(Auth::user()->role === 'employee' && $mood->mood_date->isToday())
                        <a href="{{ route('mood-tracker.edit', $mood->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Update This Mood
                        </a>
                    @endif
                    
                    <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.mood-tracker.index' : 'mood-tracker.index') }}" 
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    
                    @if(Auth::user()->role === 'admin')
                        <form action="{{ route('admin.mood-tracker.destroy', $mood->id) }}" 
                              method="POST" class="d-inline ml-2"
                              onsubmit="return confirm('Are you sure you want to delete this mood entry?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Entry
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Mood Detail Card */
.mood-detail-card {
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.mood-detail-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
    padding: 1.5rem;
}

/* Employee Info Section */
.employee-info {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    border-left: 4px solid #007bff;
}

/* Mood Display */
.mood-display {
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 15px;
    border: 2px dashed #dee2e6;
}

.mood-emoji-large {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.mood-level-badge .badge {
    font-size: 1rem;
    padding: 0.75rem 1.5rem !important;
}

/* Mood Colors */
.mood-1.badge { background-color: #dc3545; color: white; }
.mood-2.badge { background-color: #fd7e14; color: white; }
.mood-3.badge { background-color: #6c757d; color: white; }
.mood-4.badge { background-color: #17a2b8; color: white; }
.mood-5.badge { background-color: #28a745; color: white; }

/* Detail Items */
.detail-item {
    margin-bottom: 1.5rem;
    padding: 1rem;
    background-color: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
}

.detail-item h6 {
    color: #495057;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

/* Weather Display */
.weather-display {
    font-size: 1.1rem;
}

/* Workload Display */
.workload-display {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.workload-indicator {
    font-size: 1.5rem;
    letter-spacing: 3px;
}

.workload-dot {
    color: #dee2e6;
}

.workload-dot.active {
    color: #007bff;
}

.workload-description {
    margin: 0;
    font-size: 1rem;
}

/* Notes Section */
.notes-section {
    margin-top: 1rem;
}

.notes-content {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    border-left: 4px solid #28a745;
}

.notes-content blockquote {
    margin-bottom: 0;
}

.notes-content .blockquote p {
    font-style: italic;
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Timestamps */
.timestamps {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    font-size: 0.9rem;
}

.timestamps .text-muted {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .mood-display {
        margin-bottom: 2rem;
    }
    
    .workload-display {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .detail-item {
        margin-bottom: 1rem;
        padding: 0.75rem;
    }
}

/* Animation */
.mood-emoji-large {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

/* Print Styles */
@media print {
    .card {
        box-shadow: none;
        border: 1px solid #ddd;
    }
    
    .btn {
        display: none;
    }
}
</style>
@endsection