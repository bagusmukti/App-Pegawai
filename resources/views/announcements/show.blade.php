@extends('master')
@section('title', $announcement->title)
@section('page-title', 'Announcement Detail')
@section('content')

<div class="announcement-detail">
    <div class="announcement-header" style="margin-bottom: 20px;">
        <h1 class="page-title">
            {{ $announcement->title }}
            @if($announcement->is_urgent)
                <span class="badge badge-danger" style="font-size: 14px; margin-left: 10px;">URGENT</span>
            @endif
        </h1>
        
        <div class="announcement-meta" style="color: #666; margin-top: 10px;">
            <p style="margin: 5px 0;">
                <strong>Created by:</strong> {{ $announcement->creator->name ?? 'System' }}
            </p>
            <p style="margin: 5px 0;">
                <strong>Published:</strong> {{ $announcement->published_at ? $announcement->published_at->format('d M Y, H:i') : 'Draft' }}
            </p>
            <p style="margin: 5px 0;">
                <strong>Target Audience:</strong> 
                <span class="badge badge-info">{{ ucfirst($announcement->target_audience) }}</span>
            </p>
            @if($announcement->expires_at)
                <p style="margin: 5px 0;">
                    <strong>Expires:</strong> {{ $announcement->expires_at->format('d M Y, H:i') }}
                    @if($announcement->is_expired)
                        <span class="badge badge-secondary">Expired</span>
                    @endif
                </p>
            @endif
        </div>
    </div>
    
    <div class="announcement-content" style="background: #f9f9f9; padding: 20px; border-radius: 8px; line-height: 1.8;">
        {!! nl2br(e($announcement->content)) !!}
    </div>
    
    <div class="detail-actions" style="margin-top: 30px;">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this announcement?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        @endif
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.announcements.index') : route('announcements.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

@endsection