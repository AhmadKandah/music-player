<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'cover_image'];

    /**
     * العلاقة مع الأغاني
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_song')
                    ->withPivot('order', 'created_at', 'updated_at')
                    ->orderBy('playlist_song.order')
                    ->withTimestamps();
    }

    /**
     * إضافة أغنية للقائمة - نسخة معدلة
     */
    public function addSong(Song $song, $order = null)
    {
        // احسب الترتيب التلقائي إذا لم يتم تحديده
        if ($order === null) {
            $maxOrder = $this->songs()->max('playlist_song.order') ?? 0;
            $order = $maxOrder + 1;
        }
        
        // استخدم attach مع البيانات الإضافية
        return $this->songs()->attach($song->id, [
            'order' => $order,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * إزالة أغنية من القائمة
     */
    public function removeSong(Song $song)
    {
        return $this->songs()->detach($song->id);
    }

    /**
     * الحصول على عدد الأغاني
     */
    public function getSongsCountAttribute()
    {
        return $this->songs()->count();
    }
}