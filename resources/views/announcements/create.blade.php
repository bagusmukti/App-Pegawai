@extends('master')
@section('title', 'Create New Announcement')
@section('page-title', 'Create Announcement')
@section('content')

<h1 class="form-title">Create New Announcement</h1>

@if ($errors->any())
    <div style="color: red; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="form-container" action="{{ route('admin.announcements.store') }}" method="POST">
    @csrf
    
    <table class="form-table">
        <tr>
            <td><label for="title">Title:</label></td>
            <td>
                <input type="text" id="title" name="title" class="form-input" 
                       value="{{ old('title') }}" required>
            </td>
        </tr>
        
        <tr>
            <td><label for="content">Content:</label></td>
            <td>
                <textarea id="content" name="content" class="form-input" rows="6" 
                          required>{{ old('content') }}</textarea>
            </td>
        </tr>
        
        <tr>
            <td><label for="target_audience">Target Audience:</label></td>
            <td>
                <select name="target_audience" id="target_audience" class="form-input" required>
                    <option value="all" {{ old('target_audience') === 'all' ? 'selected' : '' }}>All Users</option>
                    <option value="admin" {{ old('target_audience') === 'admin' ? 'selected' : '' }}>Admin Only</option>
                    <option value="employee" {{ old('target_audience') === 'employee' ? 'selected' : '' }}>Employee Only</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <td><label for="is_urgent">Priority:</label></td>
            <td>
                <label style="display: flex; align-items: center;">
                    <input type="checkbox" name="is_urgent" id="is_urgent" value="1" 
                           {{ old('is_urgent') ? 'checked' : '' }} style="margin-right: 8px;">
                    Mark as Urgent
                </label>
            </td>
        </tr>
        
        <tr>
            <td><label for="published_at">Publish Date:</label></td>
            <td>
                <input type="datetime-local" id="published_at" name="published_at" class="form-input"
                       value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                <small style="color: #666; display: block; margin-top: 5px;">
                    Leave empty to publish immediately
                </small>
            </td>
        </tr>
        
        <tr>
            <td><label for="expires_at">Expiry Date:</label></td>
            <td>
                <input type="datetime-local" id="expires_at" name="expires_at" class="form-input"
                       value="{{ old('expires_at') }}">
                <small style="color: #666; display: block; margin-top: 5px;">
                    Optional: Set when this announcement should expire
                </small>
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td class="form-table-actions">
                <button type="submit" class="btn btn-primary">Create Announcement</button>
                <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Cancel</a>
            </td>
        </tr>
    </table>
</form>

@endsection