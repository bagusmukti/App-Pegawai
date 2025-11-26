<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyMood;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MoodTrackerController extends Controller
{
    /**
     * Display mood dashboard and history
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $period = $request->get('period', 'week'); // today, week, month
        
        if ($user->role === 'admin') {
            // Admin melihat mood trends semua karyawan
            $query = DailyMood::with(['employee', 'employee.position', 'employee.department']);
            
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
            
            $moods = $query->latest('mood_date')->paginate(20);
            
            // Ensure relationships are loaded
            $moods->load(['employee.position', 'employee.department']);
            
            // Statistics untuk admin
            $stats = [
                'avg_mood_today' => DailyMood::getAverageMood(null, 'today'),
                'avg_mood_week' => DailyMood::getAverageMood(null, 'week'),
                'avg_mood_month' => DailyMood::getAverageMood(null, 'month'),
                'total_entries_today' => DailyMood::today()->count(),
                'total_employees' => Employee::count()
            ];
            
        } else {
            // Employee melihat mood history sendiri
            $employee = Employee::where('email', $user->email)->first();
            
            if (!$employee) {
                return redirect()->back()->with('error', 'Employee profile not found.');
            }
            
            $query = DailyMood::with(['employee', 'employee.position', 'employee.department'])
                ->where('employee_id', $employee->id);
            
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
            
            $moods = $query->latest('mood_date')->paginate(20);
            
            // Statistics untuk employee
            $stats = [
                'avg_mood_week' => DailyMood::getAverageMood($employee->id, 'week'),
                'avg_mood_month' => DailyMood::getAverageMood($employee->id, 'month'),
                'today_mood' => DailyMood::where('employee_id', $employee->id)->today()->first(),
                'streak_days' => $this->calculateStreakDays($employee->id)
            ];
        }
        
        return view('mood-tracker.index', compact('moods', 'stats', 'period'));
    }

    /**
     * Show form for daily mood entry
     */
    public function create()
    {
        $user = Auth::user();
        
        // Hanya employee yang bisa input mood
        if ($user->role !== 'employee') {
            return redirect()->route('admin.mood-tracker.index')
                ->with('info', 'Only employees can submit mood entries.');
        }
        
        $employee = Employee::where('email', $user->email)->first();
        
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee profile not found.');
        }
        
        // Cek apakah sudah input mood hari ini
        $todayMood = DailyMood::where('employee_id', $employee->id)
            ->whereDate('mood_date', today())
            ->first();
            
        if ($todayMood) {
            return redirect()->route('mood-tracker.edit', $todayMood->id)
                ->with('info', 'You already submitted your mood today. You can update it below.');
        }
        
        return view('mood-tracker.create');
    }

    /**
     * Store daily mood entry
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'employee') {
            abort(403, 'Unauthorized');
        }
        
        $employee = Employee::where('email', $user->email)->first();
        
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee profile not found.');
        }
        
        $request->validate([
            'mood_level' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string|max:500',
            'weather_impact' => 'nullable|in:sunny,cloudy,rainy,hot,cold',
            'workload_level' => 'nullable|integer|min:1|max:5',
        ]);
        
        // Check if already exists for today
        $existing = DailyMood::where('employee_id', $employee->id)
            ->whereDate('mood_date', today())
            ->first();
            
        if ($existing) {
            return redirect()->route('mood-tracker.edit', $existing->id)
                ->with('error', 'You already submitted your mood today. Please update instead.');
        }
        
        DailyMood::create([
            'employee_id' => $employee->id,
            'mood_date' => today(),
            'mood_level' => $request->mood_level,
            'notes' => $request->notes,
            'weather_impact' => $request->weather_impact,
            'workload_level' => $request->workload_level,
        ]);
        
        return redirect()->route('mood-tracker.index')
            ->with('success', 'Your daily mood has been recorded successfully!');
    }

    /**
     * Show mood entry details
     */
    public function show(string $id)
    {
        $mood = DailyMood::with(['employee', 'employee.position', 'employee.department'])->findOrFail($id);
        
        // Check permission
        $user = Auth::user();
        if ($user->role !== 'admin') {
            $employee = Employee::where('email', $user->email)->first();
            if (!$employee || $mood->employee_id !== $employee->id) {
                abort(403, 'Unauthorized');
            }
        }
        
        return view('mood-tracker.show', compact('mood'));
    }

    /**
     * Show form for editing mood entry
     */
    public function edit(string $id)
    {
        $mood = DailyMood::findOrFail($id);
        
        // Check permission - only employee can edit their own mood, and only today's mood
        $user = Auth::user();
        if ($user->role !== 'employee') {
            abort(403, 'Only employees can edit mood entries');
        }
        
        $employee = Employee::where('email', $user->email)->first();
        if (!$employee || $mood->employee_id !== $employee->id) {
            abort(403, 'You can only edit your own mood entries');
        }
        
        // Only allow editing today's mood
        if (!$mood->mood_date->isToday()) {
            return redirect()->route('mood-tracker.index')
                ->with('error', 'You can only edit today\'s mood entry.');
        }
        
        return view('mood-tracker.edit', compact('mood'));
    }

    /**
     * Update mood entry
     */
    public function update(Request $request, string $id)
    {
        $mood = DailyMood::findOrFail($id);
        
        // Check permission
        $user = Auth::user();
        if ($user->role !== 'employee') {
            abort(403, 'Unauthorized');
        }
        
        $employee = Employee::where('email', $user->email)->first();
        if (!$employee || $mood->employee_id !== $employee->id) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'mood_level' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string|max:500',
            'weather_impact' => 'nullable|in:sunny,cloudy,rainy,hot,cold',
            'workload_level' => 'nullable|integer|min:1|max:5',
        ]);
        
        $mood->update([
            'mood_level' => $request->mood_level,
            'notes' => $request->notes,
            'weather_impact' => $request->weather_impact,
            'workload_level' => $request->workload_level,
        ]);
        
        return redirect()->route('mood-tracker.index')
            ->with('success', 'Your mood entry has been updated successfully!');
    }

    /**
     * Remove mood entry (admin only)
     */
    public function destroy(string $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        $mood = DailyMood::findOrFail($id);
        $mood->delete();
        
        return redirect()->route('admin.mood-tracker.index')
            ->with('success', 'Mood entry deleted successfully!');
    }
    
    /**
     * Calculate consecutive days of mood entries
     */
    private function calculateStreakDays($employeeId)
    {
        $moods = DailyMood::where('employee_id', $employeeId)
            ->orderBy('mood_date', 'desc')
            ->pluck('mood_date')
            ->map(fn($date) => Carbon::parse($date));
            
        if ($moods->isEmpty()) {
            return 0;
        }
        
        $streak = 0;
        $currentDate = today();
        
        foreach ($moods as $moodDate) {
            if ($moodDate->equalTo($currentDate)) {
                $streak++;
                $currentDate = $currentDate->subDay();
            } else {
                break;
            }
        }
        
        return $streak;
    }
}
