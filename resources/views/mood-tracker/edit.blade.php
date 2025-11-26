@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-edit"></i> Update Your Mood</h2>
            <p class="text-muted">Update your mood entry for {{ $mood->mood_date->format('l, F d, Y') }}</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-day"></i> 
                        Edit Mood Entry - {{ $mood->mood_date->format('l, F d, Y') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('mood-tracker.update', $mood->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Mood Level Selection -->
                        <div class="form-group">
                            <label class="font-weight-bold">How are you feeling today? <span class="text-danger">*</span></label>
                            <div class="mood-selector mt-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @php
                                        $emojis = ['😢', '😞', '😐', '😊', '😍'];
                                        $labels = ['Very Bad', 'Bad', 'Neutral', 'Good', 'Excellent'];
                                        $colors = ['danger', 'warning', 'secondary', 'info', 'success'];
                                        $isSelected = old('mood_level', $mood->mood_level) == $i;
                                    @endphp
                                    <div class="mood-option">
                                        <input type="radio" name="mood_level" value="{{ $i }}" id="mood_{{ $i }}" 
                                               class="mood-input" {{ $isSelected ? 'checked' : '' }}>
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
                                <option value="sunny" {{ old('weather_impact', $mood->weather_impact) == 'sunny' ? 'selected' : '' }}>☀️ Sunny - Energizing</option>
                                <option value="cloudy" {{ old('weather_impact', $mood->weather_impact) == 'cloudy' ? 'selected' : '' }}>☁️ Cloudy - Calm</option>
                                <option value="rainy" {{ old('weather_impact', $mood->weather_impact) == 'rainy' ? 'selected' : '' }}>🌧️ Rainy - Cozy/Gloomy</option>
                                <option value="hot" {{ old('weather_impact', $mood->weather_impact) == 'hot' ? 'selected' : '' }}>🔥 Hot - Exhausting</option>
                                <option value="cold" {{ old('weather_impact', $mood->weather_impact) == 'cold' ? 'selected' : '' }}>❄️ Cold - Refreshing</option>
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
                                    @php
                                        $isSelected = old('workload_level', $mood->workload_level) == $i;
                                    @endphp
                                    <div class="workload-option">
                                        <input type="radio" name="workload_level" value="{{ $i }}" id="workload_{{ $i }}" 
                                               class="workload-input" {{ $isSelected ? 'checked' : '' }}>
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
                                      placeholder="Share what's affecting your mood today... (max 500 characters)">{{ old('notes', $mood->notes) }}</textarea>
                            <small class="text-muted">What's making you feel this way? Any specific events or thoughts?</small>
                            @error('notes')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save"></i> Update My Mood
                            </button>
                            <a href="{{ route('mood-tracker.index') }}" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Original Entry Info -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="fas fa-info-circle"></i> Original Entry Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Submitted:</strong> {{ $mood->created_at->format('d M Y, H:i') }}</p>
                            <p><strong>Last Updated:</strong> {{ $mood->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Original Mood:</strong> 
                                <span class="badge badge-pill mood-{{ $mood->mood_level }} p-2">
                                    {{ $mood->mood_emoji }} {{ $mood->mood_label }}
                                </span>
                            </p>
                            @if($mood->weather_impact)
                                <p><strong>Weather:</strong> {{ $mood->weather_icon }} {{ ucfirst($mood->weather_impact) }}</p>
                            @endif
                        </div>
                    </div>
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

/* Badge styles for mood display */
.mood-1.badge { background-color: #dc3545; color: white; }
.mood-2.badge { background-color: #fd7e14; color: white; }
.mood-3.badge { background-color: #6c757d; color: white; }
.mood-4.badge { background-color: #17a2b8; color: white; }
.mood-5.badge { background-color: #28a745; color: white; }

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
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
        counter.className = 'text-muted d-block mt-1';
        this.parentNode.appendChild(counter);
    }
    
    counter.textContent = `${currentLength}/${maxLength} characters`;
    
    if (currentLength > maxLength) {
        counter.className = 'text-danger d-block mt-1';
        this.value = this.value.substring(0, maxLength);
    } else {
        counter.className = 'text-muted d-block mt-1';
    }
});

// Initialize counter on page load
document.addEventListener('DOMContentLoaded', function() {
    const notesField = document.getElementById('notes');
    if (notesField.value.length > 0) {
        notesField.dispatchEvent(new Event('input'));
    }
});
</script>
@endsection