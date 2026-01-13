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
}
