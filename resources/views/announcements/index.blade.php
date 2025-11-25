@extends('master')
@section('title', 'Company Announcements')
@section('page-title', 'Pengumuman')
@section('content')

<h1 class="page-title">Company Announcements</h1>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">
        <i class="fas fa-plus"></i> Create New Announcement
    </a>
@endif

@if($announcements->count() > 0)
    <div class="announcements-container">
        @foreach($announcements as $announcement)
            <div class="announcement-card" style="margin-bottom: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: {{ $announcement->is_urgent ? '#fff5f5' : '#f9f9f9' }};">
                <div class="announcement-header" style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                    <div>
                        <h3 style="margin: 0; color: #333;">
                            {{ $announcement->title }}
                            @if($announcement->is_urgent)
                                <span class="badge badge-danger" style="font-size: 12px; margin-left: 8px;">URGENT</span>
                            @endif
                        </h3>
                        <small style="color: #666;">
                            By: {{ $announcement->creator->name ?? 'System' }} | 
                            Published: {{ $announcement->published_at ? $announcement->published_at->format('d M Y, H:i') : 'Draft' }} |
                            Target: {{ ucfirst($announcement->target_audience) }}
                            @if($announcement->expires_at)
                                | Expires: {{ $announcement->expires_at->format('d M Y') }}
                            @endif
                        </small>
                    </div>
                    @if(auth()->user()->role === 'admin')
                        <div class="action-buttons">
                            <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
                
                <div class="announcement-content">
                    <p style="margin: 0; line-height: 1.6;">
                        {{ Str::limit($announcement->content, 200) }}
                        @if(strlen($announcement->content) > 200)
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.announcements.show', $announcement->id) : route('announcements.show', $announcement->id) }}" style="color: #007bff;">Read more...</a>
                        @endif
                    </p>
                </div>
                
                @if($announcement->is_expired)
                    <div style="margin-top: 10px;">
                        <span class="badge badge-secondary">Expired</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div style="margin-top: 20px;">
        {{ $announcements->links() }}
    </div>
@else
    <div class="empty-state" style="text-align: center; padding: 40px; color: #666;">
        <i class="fas fa-bullhorn" style="font-size: 48px; margin-bottom: 15px; color: #ddd;"></i>
        <h3>No Announcements Yet</h3>
        <p>{{ auth()->user()->role === 'admin' ? 'Create your first announcement to get started!' : 'Check back later for company updates.' }}</p>
    </div>
@endif

@endsection