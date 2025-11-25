<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'created_by',
        'target_audience',
        'is_urgent',
        'published_at',
        'expires_at'
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relasi ke User (pembuat announcement)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope untuk announcement yang masih aktif
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    // Scope untuk announcement yang sudah dipublish
    public function scopePublished($query)
    {
        return $query->where(function($q) {
            $q->whereNull('published_at')
              ->orWhere('published_at', '<=', now());
        });
    }

    // Scope berdasarkan target audience
    public function scopeForRole($query, $role)
    {
        return $query->where(function($q) use ($role) {
            $q->where('target_audience', 'all')
              ->orWhere('target_audience', $role);
        });
    }

    // Accessor untuk status expired
    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    // Accessor untuk badge class berdasarkan urgency
    public function getBadgeClassAttribute()
    {
        return $this->is_urgent ? 'badge-danger' : 'badge-info';
    }
}
