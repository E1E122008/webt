<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'description',
        'announcement_date',
        'announcement_time',
        'location',
        'priority',
        'is_active',
        'sort_order',
        'attachment_path'
    ];

    protected $casts = [
        'announcement_date' => 'date',
        // Store as raw time string (e.g., "10:27:00")
        'announcement_time' => 'string',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('announcement_date', '>=', now()->toDateString());
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('announcement_date', 'desc');
    }

    public function getFormattedDateAttribute()
    {
        return $this->announcement_date
            ? \Carbon\Carbon::parse($this->announcement_date)->locale('id')->translatedFormat('d F Y')
            : null;
    }

    public function getFormattedTimeAttribute()
    {
        if (!$this->announcement_time) {
            return null;
        }
        // announcement_time stored as string HH:MM:SS
        $time = substr((string) $this->announcement_time, 0, 5);
        // For Indonesian locale, we still show 24h HH:mm
        return $time;
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'info',
            default => 'secondary'
        };
    }
}
