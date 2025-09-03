<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Document model for managing file uploads and downloads
 * Handles file metadata, storage, and access control
 */
class Document extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'file_name',
        'original_name',
        'file_path',
        'file_size',
        'file_type',
        'category',
        'uploaded_by',
        'download_count',
        'is_public',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'download_count' => 'integer',
        'is_public' => 'boolean',
    ];

    /**
     * Get the user who uploaded the document
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope to filter public documents
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope to filter by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to search by title or description
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('original_name', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to order by latest
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope to order by most downloaded
     */
    public function scopePopular($query)
    {
        return $query->orderBy('download_count', 'desc');
    }

    /**
     * Get human readable file size
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes === 0) {
            return '0 Bytes';
        }
        
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes) / log($k));
        
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    /**
     * Get the file extension
     */
    public function getFileExtensionAttribute()
    {
        return pathinfo($this->original_name, PATHINFO_EXTENSION);
    }

    /**
     * Check if file is an image
     */
    public function getIsImageAttribute()
    {
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        return in_array(strtolower($this->file_extension), $imageTypes);
    }

    /**
     * Check if file is a PDF
     */
    public function getIsPdfAttribute()
    {
        return strtolower($this->file_extension) === 'pdf';
    }

    /**
     * Check if file is a document
     */
    public function getIsDocumentAttribute()
    {
        $docTypes = ['doc', 'docx', 'txt', 'rtf', 'odt'];
        return in_array(strtolower($this->file_extension), $docTypes);
    }

    /**
     * Check if file is a spreadsheet
     */
    public function getIsSpreadsheetAttribute()
    {
        $spreadsheetTypes = ['xls', 'xlsx', 'csv', 'ods'];
        return in_array(strtolower($this->file_extension), $spreadsheetTypes);
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    /**
     * Get the full file path for storage
     */
    public function getFullFilePathAttribute()
    {
        return storage_path('app/public/' . $this->file_path);
    }

    /**
     * Get the public URL for the file
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Delete physical file when model is deleted
        static::deleting(function ($document) {
            if ($document->file_path && file_exists($document->full_file_path)) {
                unlink($document->full_file_path);
            }
        });
    }
}
