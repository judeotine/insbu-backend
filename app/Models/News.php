<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * News model for managing news articles and posts
 * Handles content creation, publishing, and categorization
 */
class News extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'excerpt',
        'status',
        'image_url',
        'category',
        'reading_time',
        'author_id',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'reading_time' => 'integer',
    ];

    /**
     * Available status options
     */
    const STATUSES = [
        'draft' => 'Draft',
        'pending' => 'Pending Review',
        'published' => 'Published',
        'archived' => 'Archived',
    ];

    /**
     * Get the author of the news article
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope to filter published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope to filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to order by latest
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope to search by title or content
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('body', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%");
        });
    }

    /**
     * Get the excerpt or generate one from body
     */
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }

        // Generate excerpt from body if not provided
        return substr(strip_tags($this->body), 0, 200) . '...';
    }

    /**
     * Auto-calculate reading time based on word count
     */
    public function calculateReadingTime()
    {
        $wordCount = str_word_count(strip_tags($this->body));
        // Average reading speed: 200 words per minute
        $minutes = ceil($wordCount / 200);
        
        $this->reading_time = max(1, $minutes); // Minimum 1 minute
        return $this->reading_time;
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-calculate reading time when creating/updating
        static::saving(function ($news) {
            if ($news->isDirty('body')) {
                $news->calculateReadingTime();
            }
        });

        // Set published_at when status changes to published
        static::saving(function ($news) {
            if ($news->isDirty('status') && $news->status === 'published' && !$news->published_at) {
                $news->published_at = now();
            }
        });
    }
}
