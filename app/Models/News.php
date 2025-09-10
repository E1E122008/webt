<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category',
        'status',
        'author_id',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-news.jpg');
    }

    public function getExcerptAttribute()
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->content), 150);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = \Illuminate\Support\Str::slug($news->title);
                
                // Ensure slug is unique
                $originalSlug = $news->slug;
                $count = 1;
                while (static::where('slug', $news->slug)->exists()) {
                    $news->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        static::updating(function ($news) {
            if ($news->isDirty('title') && empty($news->slug)) {
                $news->slug = \Illuminate\Support\Str::slug($news->title);
                
                // Ensure slug is unique
                $originalSlug = $news->slug;
                $count = 1;
                while (static::where('slug', $news->slug)->where('id', '!=', $news->id)->exists()) {
                    $news->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }
}
