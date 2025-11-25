<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Admin melihat semua announcement, Employee hanya yang sesuai target audience
        if ($user->role === 'admin') {
            $announcements = Announcement::with('creator')
                ->latest('created_at')
                ->paginate(10);
        } else {
            $announcements = Announcement::with('creator')
                ->published()
                ->active()
                ->forRole('employee')
                ->latest('created_at')
                ->paginate(10);
        }

        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya admin yang bisa create
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        return view('announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Hanya admin yang bisa create
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|in:all,admin,employee',
            'is_urgent' => 'boolean',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'created_by' => Auth::id(),
            'target_audience' => $request->target_audience,
            'is_urgent' => $request->has('is_urgent'),
            'published_at' => $request->published_at ? $request->published_at : now(),
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $announcement = Announcement::with('creator')->findOrFail($id);
        
        // Cek permission berdasarkan role
        $user = Auth::user();
        if ($user->role !== 'admin') {
            // Employee hanya bisa lihat announcement yang sesuai target audience dan masih aktif
            if ($announcement->target_audience === 'admin' || 
                ($announcement->expires_at && $announcement->expires_at->isPast())) {
                abort(403, 'Unauthorized');
            }
        }

        return view('announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Hanya admin yang bisa edit
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $announcement = Announcement::findOrFail($id);
        return view('announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Hanya admin yang bisa update
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|in:all,admin,employee',
            'is_urgent' => 'boolean',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
        ]);

        $announcement = Announcement::findOrFail($id);
        
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'target_audience' => $request->target_audience,
            'is_urgent' => $request->has('is_urgent'),
            'published_at' => $request->published_at ? $request->published_at : $announcement->published_at,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hanya admin yang bisa delete
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }
}
