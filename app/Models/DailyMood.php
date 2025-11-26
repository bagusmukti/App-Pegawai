<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DailyMood extends Model
{
    protected $fillable = [
        'employee_id',
        'mood_date', 
        'mood_level',
        'notes',
        'weather_impact',
        'workload_level'
    ];

    protected $casts = [
        'mood_date' => 'date',
        'mood_level' => 'integer',
        'workload_level' => 'integer',
    ];

    // Relasi ke Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessor untuk mood emoji
    public function getMoodEmojiAttribute()
    {
        return match($this->mood_level) {
            1 => '😢', // Very Bad
            2 => '😞', // Bad  
            3 => '😐', // Neutral
            4 => '😊', // Good
            5 => '😍', // Excellent
            default => '😐'
        };
    }

    // Accessor untuk mood label
    public function getMoodLabelAttribute()
    {
        return match($this->mood_level) {
            1 => 'Very Bad',
            2 => 'Bad',
            3 => 'Neutral', 
            4 => 'Good',
            5 => 'Excellent',
            default => 'Unknown'
        };
    }

    // Accessor untuk workload label
    public function getWorkloadLabelAttribute()
    {
        return match($this->workload_level) {
            1 => 'Very Light',
            2 => 'Light',
            3 => 'Moderate',
            4 => 'Heavy', 
            5 => 'Very Heavy',
            default => 'Not Set'
        };
    }

    // Accessor untuk weather icon
    public function getWeatherIconAttribute()
    {
        return match($this->weather_impact) {
            'sunny' => '☀️',
            'cloudy' => '☁️',
            'rainy' => '🌧️',
            'hot' => '🔥',
            'cold' => '❄️',
            default => '🌤️'
        };
    }

    // Accessor untuk CSS class berdasarkan mood
    public function getMoodColorClassAttribute()
    {
        return match($this->mood_level) {
            1 => 'mood-very-bad',   // Red
            2 => 'mood-bad',        // Orange  
            3 => 'mood-neutral',    // Gray
            4 => 'mood-good',       // Light Green
            5 => 'mood-excellent',  // Green
            default => 'mood-neutral'
        };
    }

    // Scope untuk mood hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('mood_date', today());
    }

    // Scope untuk mood minggu ini
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('mood_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    // Scope untuk mood bulan ini
    public function scopeThisMonth($query) 
    {
        return $query->whereMonth('mood_date', now()->month)
                    ->whereYear('mood_date', now()->year);
    }

    // Static method untuk mendapatkan rata-rata mood
    public static function getAverageMood($employeeId = null, $period = 'week')
    {
        $query = static::query();
        
        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }
        
        switch ($period) {
            case 'today':
                $query->today();
                break;
            case 'week':
                $query->thisWeek();
                break;
            case 'month':
                $query->thisMonth();
                break;
        }
        
        return round($query->avg('mood_level'), 1);
    }
}
