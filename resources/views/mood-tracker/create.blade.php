@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-smile"></i> Record Your Daily Mood</h2>
            <p class="text-muted">How are you feeling today? Your wellness matters!</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-day"></i> 
                        Today's Mood Entry - {{ today()->format('l, F d, Y') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('mood-tracker.store') }}" method="POST">
                        @csrf
                        
                        <!-- Mood Level Selection -->
                        <div class="form-group">
                            <label class="font-weight-bold">How are you feeling today? <span class="text-danger">*</span></label>
                            <div class="mood-selector mt-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @php
                                        $emojis = ['😢', '😞', '😐', '😊', '😍'];
                                        $labels = ['Very Bad', 'Bad', 'Neutral', 'Good', 'Excellent'];
                                        $colors = ['danger', 'warning', 'secondary', 'info', 'success'];
                                    @endphp
                                    <div class="mood-option">
                                        <input type="radio" name="mood_level" value="{{ $i }}" id="mood_{{ $i }}" 
                                               class="mood-input" {{ old('mood_level') == $i ? 'checked' : '' }}>
                                        <label for="mood_{{ $i }}" class="mood-label mood-{{ $i }}">
                                            <div class="mood-emoji">{{ $emojis[$i-1] }}</div>
                                            <div class="mood-text">{{ $labels[$i-1] }}</div>
                                        </label>
                                    </div>
                                @endfor
                            </div>
                            @error('mood_level')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Weather Impact -->
                        <div class="form-group">
                            <label class="font-weight-bold">Weather Impact (Optional)</label>
                            <select name="weather_impact" class="form-control">
                                <option value="">Select weather impact...</option>
                                <option value="sunny" {{ old('weather_impact') == 'sunny' ? 'selected' : '' }}>☀️ Sunny - Energizing</option>
                                <option value="cloudy" {{ old('weather_impact') == 'cloudy' ? 'selected' : '' }}>☁️ Cloudy - Calm</option>
                                <option value="rainy" {{ old('weather_impact') == 'rainy' ? 'selected' : '' }}>🌧️ Rainy - Cozy/Gloomy</option>
                                <option value="hot" {{ old('weather_impact') == 'hot' ? 'selected' : '' }}>🔥 Hot - Exhausting</option>
                                <option value="cold" {{ old('weather_impact') == 'cold' ? 'selected' : '' }}>❄️ Cold - Refreshing</option>
                            </select>
                            @error('weather_impact')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Workload Level -->
                        <div class="form-group">
                            <label class="font-weight-bold">Workload Level (Optional)</label>
                            <div class="workload-selector mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <div class="workload-option">
                                        <input type="radio" name="workload_level" value="{{ $i }}" id="workload_{{ $i }}" 
                                               class="workload-input" {{ old('workload_level') == $i ? 'checked' : '' }}>
                                        <label for="workload_{{ $i }}" class="workload-label">
                                            <div class="workload-dots">
                                                @for($j = 1; $j <= 5; $j++)
                                                    <span class="workload-dot {{ $j <= $i ? 'active' : '' }}">●</span>
                                                @endfor
                                            </div>
                                            <div class="workload-text">
                                                @switch($i)
                                                    @case(1) Very Light @break
                                                    @case(2) Light @break
                                                    @case(3) Moderate @break
                                                    @case(4) Heavy @break
                                                    @case(5) Very Heavy @break
                                                @endswitch
                                            </div>
                                        </label>
                                    </div>
                                @endfor
                            </div>
                            @error('workload_level')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="form-group">
                            <label for="notes" class="font-weight-bold">Additional Notes (Optional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" 
                                      placeholder="Share what's affecting your mood today... (max 500 characters)">{{ old('notes') }}</textarea>
                            <small class="text-muted">What's making you feel this way? Any specific events or thoughts?</small>
                            @error('notes')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Record My Mood
                            </button>
                            <a href="{{ route('mood-tracker.index') }}" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Mood Selector Styles */
.mood-selector {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
}

.mood-option {
    flex: 1;
    min-width: 100px;
}

.mood-input {
    display: none;
}

.mood-label {
    display: block;
    text-align: center;
    padding: 20px 10px;
    border: 3px solid #e9ecef;
    border-radius: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.mood-label:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.mood-emoji {
    font-size: 2.5rem;
    margin-bottom: 8px;
}

.mood-text {
    font-weight: bold;
    font-size: 0.9rem;
}

/* Mood Colors */
.mood-1 .mood-label { border-color: #dc3545; }
.mood-2 .mood-label { border-color: #fd7e14; }
.mood-3 .mood-label { border-color: #6c757d; }
.mood-4 .mood-label { border-color: #17a2b8; }
.mood-5 .mood-label { border-color: #28a745; }

.mood-input:checked + .mood-1 { background-color: #dc3545; color: white; }
.mood-input:checked + .mood-2 { background-color: #fd7e14; color: white; }
.mood-input:checked + .mood-3 { background-color: #6c757d; color: white; }
.mood-input:checked + .mood-4 { background-color: #17a2b8; color: white; }
.mood-input:checked + .mood-5 { background-color: #28a745; color: white; }

/* Workload Selector Styles */
.workload-selector {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.workload-option {
    flex: 1;
    min-width: 120px;
}

.workload-input {
    display: none;
}

.workload-label {
    display: block;
    text-align: center;
    padding: 15px 10px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.workload-label:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.workload-input:checked + .workload-label {
    border-color: #007bff;
    background-color: #e7f3ff;
}

.workload-dots {
    font-size: 1.2rem;
    letter-spacing: 3px;
    margin-bottom: 5px;
}

.workload-dot {
    color: #dee2e6;
}

.workload-dot.active {
    color: #007bff;
}

.workload-text {
    font-size: 0.85rem;
    font-weight: 600;
    color: #6c757d;
}

.workload-input:checked + .workload-label .workload-text {
    color: #007bff;
}

/* Card Styles */
.card {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    border: none;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .mood-selector {
        flex-direction: column;
    }
    
    .mood-option {
        min-width: auto;
    }
    
    .workload-selector {
        flex-direction: column;
    }
    
    .workload-option {
        min-width: auto;
    }
}
</style>

<script>
// Character counter for notes
document.getElementById('notes').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;
    
    // Find or create counter element
    let counter = document.getElementById('notes-counter');
    if (!counter) {
        counter = document.createElement('small');
        counter.id = 'notes-counter';
        counter.className = 'text-muted';
        this.parentNode.appendChild(counter);
    }
    
    counter.textContent = `${currentLength}/${maxLength} characters`;
    
    if (currentLength > maxLength) {
        counter.className = 'text-danger';
        this.value = this.value.substring(0, maxLength);
    } else {
        counter.className = 'text-muted';
    }
});

// Auto-focus on first mood option for accessibility
document.addEventListener('DOMContentLoaded', function() {
    const firstMoodOption = document.getElementById('mood_3'); // Start with neutral
    if (firstMoodOption && !document.querySelector('input[name="mood_level"]:checked')) {
        // firstMoodOption.focus(); // Don't auto-select, let user choose
    }
});
</script>
@endsection