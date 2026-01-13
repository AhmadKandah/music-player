<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها
     */
    protected $fillable = [
        'title',
        'artist',
        'album',
        'file_path',
        'cover_image',
        'duration'
    ];

    /**
     * الحقول التي يجب إخفاؤها
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * الحقول ذات الأنواع الخاصة
     */
    protected $casts = [
        'duration' => 'integer'
    ];

    public function playlists()
{
    return $this->belongsToMany(Playlist::class, 'playlist_song')
                ->withPivot('order')
                ->withTimestamps();
}

    /**
     * تنظيف مسار الملف للتعامل مع المسارات القديمة والجديدة
     */
    public function getCleanFilePath()
    {
        $path = $this->attributes['file_path'] ?? $this->file_path;
        
        // إذا كان المسار يبدأ بـ storage/، قم بإزالته
        if (strpos($path, 'storage/') === 0) {
            $path = str_replace('storage/', '', $path);
        }
        
        // إذا كان المسار يحتوي على app/public/، قم بتحويله
        if (strpos($path, 'app/public/') !== false) {
            $path = str_replace('app/public/', '', $path);
        }
        
        return $path;
    }
    
    /**
     * الحصول على URL الملف مع دعم المسارات القديمة والجديدة
     */
    public function getFileUrlAttribute()
    {
        return asset($this->getCleanFilePath());
    }
}
